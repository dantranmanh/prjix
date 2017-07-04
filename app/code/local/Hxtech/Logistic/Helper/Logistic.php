<?php

class Hxtech_Logistic_Helper_Logistic extends Mage_Core_Helper_Abstract
{
    public function getLogisticRoleId()
    {
        return Hxtech_Logistic_Model_Logistic::LOGISTIC_ROLE_ID;
    }

    public function isLogisticUser()
    {
        return Mage::getSingleton('admin/session')->getUser()->getIsLogisticUser();
    }

    public function isAdminUser()
    {
        return !Mage::getSingleton('admin/session')->getUser()->getIsLogisticUser();
    }

    public function getCurrentAdminUserId()
    {
        return Mage::getSingleton('admin/session')->getUser()->getId();
    }

    public function generateLogisticCmsPage($logistic)
    {
        $logisticName = $logistic->getUsername();
        $identifier = $this->getCmsPageIdentifier($logisticName);

        $cmsPageData = array(
            'title' => $logisticName,
            'root_template' => 'one_column',
            'identifier' =>  $identifier,
            'stores' => array(0),//available for all store views
            'content' => $this->generateCmsPageContent($logistic)
        );
        try {
            $model = Mage::getModel('cms/page');
            $model->setData($cmsPageData)->save();
            return true;
        } catch (Exception $e){
            // Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return '';
        }
    }

    public function getCmsPageIdentifier($logisticName)
    {
        return strtolower(str_replace(' ', '-', $logisticName));
    }

    protected function generateCmsPageContent($logistic)
    {
        $content = '';
        $content .=
            '<div class="vendor-landing-title">
                <div class="logo-desc">
                    <img class="vendor-landing-logo" src="{{config path="web/unsecure/base_url"}}media/logistic/logo/'.$logistic->getLogisticLogo().'" alt="vendor-logo" />
                    <p><label>Telephone number: '.$logistic->getTelephone().'</label></p>
                </div>
                
                <div class="logis-info">
                    <h1 class="vendor-name">
                        '.$logistic->getUsername().'
                        <a class="contact-seller" href="#"><span>Contact Logistics Supplier</span></a>
                    </h1>
                    <p>'.$logistic->getDescription().'</p>
                </div>
            </div>';
        return $content;
    }

    public function getLogisticLogoSrc($logistic)
    {
        return Mage::getBaseUrl('media').'logistic'.DS.'logo'.DS.$logistic->getLogisticLogo();
    }

    public function getTotalRowValues()
    {
        $result = array();

        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $_items = $quote->getAllItems();
        $_totalOuterPrice = 0;
        $_totalOuterVolume = 0;
        $_totalOuterPallet = 0;
        $_totalLineVolume = 0;
        $_totalNetOuterWeight = 0;
        $_totalNetWeight = 0;
        $_totalGrossOuterWeight = 0;
        $_totalGrossWeight = 0;
        $_totalUnits = 0;
        $_totalLineValue = 0;
        $_totalOuters = 0;

        foreach ($_items as $_item) {
            $_qty = $_item->getQty();
            $_product = $_item->getProduct();
            $_id = $_product->getId();
            $_totalOuterPrice += $_product->getFinalPrice();
            $_totalOuterVolume += Mage::helper('logistic')->getProductAttribute($_id, 'product_case_volume');
            $_totalOuterPallet += Mage::helper('logistic')->getProductAttribute($_id, 'product_volume_per_pallet');
            $_totalLineVolume += $this->getTotalLineVolumeOfProduct($_product, $_qty);
            $_totalNetOuterWeight += Mage::helper('logistic')->getProductAttribute($_id, 'product_net_weight');
            $_totalNetWeight += $_qty * Mage::helper('logistic')->getProductAttribute($_id, 'product_net_weight');
            $_totalGrossOuterWeight += $_product->getWeight();
            $_totalGrossWeight += $_qty * $_product->getWeight();
            $_totalUnits += $this->getTotalUnits($_product, $_qty);
            $_totalLineValue += $_item->getRowTotalInclTax();

            $outersPerPallet = Mage::helper('logistic')->getProductAttribute($_id, 'product_cases_per_pallet');
            $_totalOuters += $_qty;
            // if(Mage::helper('logistic')->getProductAttribute($_id, 'product_type') == 58){
            //     $_totalOuters += $_qty;
            // }else{
            //     $_totalOuters += $_qty * $outersPerPallet;    
            // }   
        }

        $result['total_outer_price'] = $_totalOuterPrice;
        $result['total_outer_volume'] = $_totalOuterVolume;
        $result['total_pallet_volume'] = $_totalOuterPallet;
        $result['total_line_volume'] = $_totalLineVolume;
        $result['total_net_outer_weight'] = $_totalNetOuterWeight;
        $result['total_net_weight'] = $_totalNetWeight;
        $result['total_gross_outer_weight'] = $_totalGrossOuterWeight;
        $result['total_gross_weight'] = $_totalGrossWeight;
        $result['total_units'] = $_totalUnits;
        $result['total_line_value'] = $_totalLineValue;
        $result['total_outers'] = $_totalOuters; 

        return $result;
    }

    public function getGrandTotalInclShippingrate($shippingRate, $totalRowValues)
    {
        $totalLineValue = $totalRowValues['total_line_value'];
        $logisticValue = $totalRowValues['total_line_volume'] * $shippingRate->getPriceCbm();
        $documentationFee = $shippingRate->getDocumentationFee();
        $customsClearance = $shippingRate->getCustomsClearance();
        $aqisClearance= $shippingRate->getAqisClearance();

        $grandTotal = $totalLineValue + $logisticValue + $documentationFee + $customsClearance + $aqisClearance;
        return $grandTotal;
    }
	
	
	public function getShippingTotalInclShippingrate($shippingRate, $totalRowValues)
    {
        $totalLineValue = $totalRowValues['total_line_value'];
        $logisticValue = $totalRowValues['total_line_volume'] * $shippingRate->getPriceCbm();
        $documentationFee = $shippingRate->getDocumentationFee();
        $customsClearance = $shippingRate->getCustomsClearance();
        $aqisClearance= $shippingRate->getAqisClearance();

        $totalShipping = $logisticValue + $documentationFee + $customsClearance + $aqisClearance;
        return $totalShipping;
    }

    public function getLogisticOfShippingrate($shippingrate)
    {
        $logisticId = $shippingrate->getLogisticUserId();
        $logistic = Mage::getModel('admin/user')->load($logisticId);
        return $logistic;
    }

    public function sendLogisticOrderEmail($logistic, $storeId, $order, $paymentBlockHtml, $shippingrate)
    {
        $templateId = Hxtech_Logistic_Model_Logistic::LOGISTIC_ORDER_EMAIL_TEMPLATE;

        $logisticEmail = $logistic->getEmail();
        /** @var $mailer Mage_Core_Model_Email_Template_Mailer */
        $mailer = Mage::getModel('core/email_template_mailer');
        /** @var $emailInfo Mage_Core_Model_Email_Info */
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo($logisticEmail, $logistic->getUsername());
        $mailer->addEmailInfo($emailInfo);

        // Set all required params and send emails
        $mailer->setSender(Mage::getStoreConfig(Mage_Sales_Model_Order::XML_PATH_EMAIL_IDENTITY, $storeId));
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams(array(
            'commission_fee' => Mage::helper('core')->currency($order->getCommissionFee(), true, false),
            'shippingrate' => $shippingrate,
            'shipping_amount' => Mage::helper('core')->currency($order->getShippingAmount(), true, false),
            'order'        => $order,
            'billing'      => $order->getBillingAddress(),
            'payment_html' => $paymentBlockHtml
        ));

        /** @var $emailQueue Mage_Core_Model_Email_Queue */
        $emailQueue = Mage::getModel('core/email_queue');
        $emailQueue->setEntityId($order->getId())
            ->setEntityType(Mage_Sales_Model_Order::ENTITY)
            ->setEventType(Mage_Sales_Model_Order::EMAIL_EVENT_NAME_NEW_ORDER)
            ->setIsForceCheck(!false);

        $mailer->setQueue($emailQueue)->send();

        return $this;
    }

    public function getLogisticNameOfShippingrate($shippingrate)
    {
        $logisticId = $shippingrate->getLogisticUserId();
        $logistic = Mage::getModel('admin/user')->load($logisticId);
        $logisticName = $logistic->getUsername();
        return $logisticName;
    } 

    public function getTotalUnits($product, $qty)
    {
        return $qty * Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_units_per_case');
        // $outersPerPallet = Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_cases_per_pallet');
        // if(Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_type') == 58){
        //     return $qty * Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_units_per_case');
        // }else{
        //     return $qty * Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_units_per_case') * $outersPerPallet;    
        // }    
    }

    public function getTotalCbm()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $_items = $quote->getAllItems();
        $_totalLineVolume = 0;

        foreach ($_items as $_item) {
            $_qty = $_item->getQty();
            $_product = $_item->getProduct();
            $_totalLineVolume += $this->getTotalLineVolumeOfProduct($_product, $_qty);
        }

        return $_totalLineVolume;  
    }

    public function getTotalLineVolumeOfProduct($product, $qty)
    {
        return $qty * Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_case_volume');
        // if(Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_type') == 58){
        //     //outer
        //     return $qty * Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_case_volume');
        // }else{
        //     //pallet
        //     return $qty * Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_volume_per_pallet');   
        // }   
    }

    public function getProductTypeLabel($product)
    {
        $html = '';

        $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
        if($isLoggedIn){
           $html .= '<select name="logisticType" onchange="reloadProductPrice(this, '.$product->getId().')" class="productTypeDdl productType-'.$product->getId().'">';
            $html .= '<option value="case">Case</option>';
            $html .= '<option value="pallet">Pallet</option>';
            $html .= '</select>'; 
        }

        return $html;
    }

    public function getProductUnit($product, $type)
    {
        $unitsPerCase = Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_units_per_case');
        $casesPerPallet = Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_cases_per_pallet');
        if($type == 'pallet'){
            return $unitsPerCase * $casesPerPallet;
        }else{
            return $unitsPerCase;
        }
    }

    public function hasProducts($category)
    {
        $productCount = $category->getProductCount();
        $childCategories = $category->getChildrenCategories();
        if($productCount > 0 || count($childCategories) > 0){
            return true;
        }
        return false;
    }


    public function getProductUnitLabel($product)
    {
        $html = '';

        $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
        if($isLoggedIn){
            $html .= '<span class="product-unit-'.$product->getId().'">';
            $html .= $this->getProductUnit($product, 'case');
            $html .= ' units / case';
            $html .= '</span>';     
        }

        return $html;
    }

    public function getProductType($product){
        $html = '';
        $productType = Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_type');
        if($productType){
            if($productType == '58'){
                $html .= 'Case';
            }else if($productType == '59'){
                $html .= 'Pallet';
            }
        }
        return $html;
    }

    public function getProductUnitWeightHtml($product)
    {
        $html = '';
        $unitWeight = Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_unit_weight');
        if($unitWeight){
            $html .= $unitWeight . 'g';
        }
        return $html;
    }

    public function getQtyByPallet($product, $qty)
    {
    	$casesPerPallet = Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_cases_per_pallet');
    	if($casesPerPallet){
    		return $qty * $casesPerPallet;
    	}
    	return $qty; 
    }

    public function getQtyByCase($product, $qty)
    {
        $unitsPerCase = Mage::helper('logistic')->getProductAttribute($product->getId(), 'product_units_per_case');

        if($unitsPerCase){
            return $qty * $unitsPerCase;
        }
        return $qty; 
    }

    public function getLogisticCommissionType($logisticId)
    {
        $logistic = Mage::getModel('admin/user')->load($logisticId);
        return $logistic->getCommissionType();
    }

    public function getLogisticCommissionFee($logisticId, $order)
    {
        $commissionFee = 0;
        $subTotal = $order->getSubtotal();
        $logistic = Mage::getModel('admin/user')->load($logisticId);
        $commissionType = $logistic->getCommissionType();
        $commissionFixedFee = $logistic->getCommissionFixedFee();
        $commissionPercentageFee = $logistic->getCommissionPercentageFee() * $subTotal / 100;
        switch ($commissionType) {
            case Hxtech_Logistic_Model_Logistic::COMMISSION_FIXED_TYPE: // Commission Algorithm is fixed fee
                $commissionFee += $commissionFixedFee;
                break;
            case Hxtech_Logistic_Model_Logistic::COMMISSION_PERCENTAGE_TYPE: // Commission Algorithm is percentage fee
                $commissionFee += $commissionPercentageFee;
                break;
            case Hxtech_Logistic_Model_Logistic::COMMISSION_COMPARISON_TYPE: // Commission Algorithm is tier
                $commissionFee += $this->getTierCommissionFee($logistic, $subTotal);
                break;
            default:
                $commissionFee = 0; //Commission Fee = 0 by default
        }
        return $commissionFee;
    }

    public function getTierCommissionFee($logistic, $subTotal)
    {
        $commissionFee = 0;
        $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
        if($isLoggedIn){
            $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        }else{
            $groupId = 0;
        }
        $tierCollection = Mage::getModel('logistic/tiercommission')->getCollection();
        $tierCollection
            ->addFieldToFilter('logistic_user_id', $logistic->getId())
            ->addFieldToFilter(
                array('cust_group', 'cust_group'),
                array(
                    array('eq'=> $groupId), 
                    array('eq'=> Mage_Customer_Model_Group::CUST_GROUP_ALL)
                )
            )
            ->addFieldToFilter('price_min', array('lt' => $subTotal))
            ->addFieldToFilter('price_max', array('gt' => $subTotal));
            
        $countTierOptions = count($tierCollection->getData());
        if($countTierOptions = 1){ //in case there is only 1 tier options matched the conditions. 
            $item = $tierCollection->getFirstItem();
            $percentageFee = $item->getPercentage() * $subTotal / 100;
            $fixedFee = $item->getFixedFee();
            $commissionFee += max($fixedFee, $percentageFee);
        }

        return $commissionFee;
    }

    public function getCalculatedGrandTotal()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $shippingrateId = $quote->getShippingRateId();
        $shippingrate = Mage::getModel('logistic/shippingrate')->load($shippingrateId);
        $totalRowValues = Mage::helper('logistic/logistic')->getTotalRowValues();
        if($shippingrate){
            $total = Mage::helper('logistic/logistic')->getGrandTotalInclShippingrate($shippingrate, $totalRowValues);
        }else{
            $total = $totalRowValues['total_line_value'];
        }

        $documentationFee = Mage::helper('document/documentation')->getDocumentationFeeByQuote($quote);

        $importerCommissionFee = Mage::helper('logistic/importer')->getImporterCommissionFee($totalRowValues['total_line_value']);
        $total += $documentationFee;
        $total += $importerCommissionFee;

        return $total;
    }
}