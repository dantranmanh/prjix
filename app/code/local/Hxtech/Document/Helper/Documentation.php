<?php

class Hxtech_Document_Helper_Documentation extends Mage_Core_Helper_Abstract
{
    public function getSupplierOfDocumentation($documentation)
    {
        $supplierId = $documentation->getDocumentUserId();
        $supplier = Mage::getModel('admin/user')->load($supplierId);
        return $supplier;
    }

    public function getSupplierNameOfDocumentation($documentation)
    {
        $supplier = $this->getSupplierOfDocumentation($documentation);
        return $supplier->getUsername();
    }   

    public function getSupplierLogoOfDocumentation($documentationId)
    {
    	$documentation = Mage::getModel('document/documentation')->load($documentationId);
        $supplier = $this->getSupplierOfDocumentation($documentation);

        $src = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'logistic'.DS.'logo'.DS.$supplier->getLogisticLogo();
        $html = '<img width="200px" src="'.$src.'"/>';
        return $html;
    } 

    public function getDocumentTypeHtml($documentationId)
    {
    	$documentation = Mage::getModel('document/documentation')->load($documentationId);
        $html = '';
        $documentTypes = explode(',',$documentation->getDocumentType());
        foreach($documentTypes as $type){
            $html .= $type.'<br/>';
        }
        return $html;
    }

    public function getSupplierFilteredIds()
    {
        $docIds = array();
        $quote = Mage::getModel('checkout/cart')->getQuote();
        foreach ($quote->getAllItems() as $item) {
            $product = $item->getProduct();
            $productFoodCategoryValue = Mage::helper('document')->getProductAttribute($product->getId(), 'product_food_category');
            $docIds = $this->getDocumentationIdsByFcv($productFoodCategoryValue, $docIds);
        }
        return $docIds;
    }

    public function getDocumentationIdsByFcv($productFoodCategoryValue, $docIds)
    {
        $collection = Mage::getModel('document/documentation')->getCollection();
        foreach($collection as $documentation){
            $productTypes = explode(',', $documentation->getProductType());
            foreach($productTypes as $type){
                if($type == $productFoodCategoryValue){
                    array_push($docIds, $documentation->getId());
                }
            }
        }
        return $docIds;
    }

    public function isDairyProductExist()
    {
        $docIds = array();
        $quote = Mage::getModel('checkout/cart')->getQuote();
        foreach ($quote->getAllItems() as $item){
            $product = $item->getProduct();
            $productFoodCategoryValue = Mage::helper('document')->getProductAttribute($product->getId(), 'product_food_category');
            $docIds = $this->getDocumentationIdsByFcv($productFoodCategoryValue, $docIds);
        }
        if(in_array(1, $docIds)){
            return true;
        }
        return false;
    }

    public function getExportingDocIds($collection, $countryId)
    {
    	$docIds = array();
    	foreach($collection as $documentation)
    	{
    		$countryIds = explode(',', $documentation->getExportingCountry());
    		foreach($countryIds as $documentCountryId){
                if($documentCountryId == $countryId){
                    array_push($docIds, $documentation->getId());
                }
            }
    	}
    	return $docIds;
    }

    public function getImportingDocIds($collection, $countryId)
    {
    	$docIds = array();
    	foreach($collection as $documentation)
    	{
    		$countryIds = explode(',', $documentation->getImportingCountry());
    		foreach($countryIds as $documentCountryId){
                if($documentCountryId == $countryId){
                    array_push($docIds, $documentation->getId());
                }
            }
    	}
    	return $docIds;
    }

    public function sendDocumentationOrderEmail($documentation, $storeId, $order, $paymentBlockHtml, $shippingrate)
    {
        $templateId = Hxtech_Logistic_Model_Logistic::DOCUMENT_ORDER_EMAIL_TEMPLATE;

        $supplier = $this->getSupplierOfDocumentation($documentation);
        $supplierEmail = $supplier->getEmail();
        /** @var $mailer Mage_Core_Model_Email_Template_Mailer */
        $mailer = Mage::getModel('core/email_template_mailer');
        /** @var $emailInfo Mage_Core_Model_Email_Info */
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo($supplierEmail, $supplier->getUsername());
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

    public function getDocumentCommissionType($documentId)
    {
        $document = Mage::getModel('admin/user')->load($documentId);
        return $document->getCommissionType();
    }

    public function getDocumentationTotalFee($document, $subTotal)
    {
        $supplier = $this->getSupplierOfDocumentation($document);
        return $document->getPrice() + $this->getDocumentCommissionFee($supplier->getId(), $subTotal);
    }

    public function getDocumentCommissionFee($documentId, $subTotal)
    {
        $commissionFee = 0;
        $document = Mage::getModel('admin/user')->load($documentId);
        $commissionType = $document->getCommissionType();
        $commissionFixedFee = $document->getCommissionFixedFee();
        $commissionPercentageFee = $document->getCommissionPercentageFee() * $subTotal / 100;
        switch ($commissionType) {
            case Hxtech_Logistic_Model_Logistic::COMMISSION_FIXED_TYPE: // Commission Algorithm is fixed fee
                $commissionFee += $commissionFixedFee;
                break;
            case Hxtech_Logistic_Model_Logistic::COMMISSION_PERCENTAGE_TYPE: // Commission Algorithm is percentage fee
                $commissionFee += $commissionPercentageFee;
                break;
            case Hxtech_Logistic_Model_Logistic::COMMISSION_COMPARISON_TYPE: // Commission Algorithm is tier
                $commissionFee += $this->getTierCommissionFee($document, $subTotal);
                break;
            default:
                $commissionFee = 0; //Commission Fee = 0 by default
        }
        return $commissionFee;
    }

    public function getTierCommissionFee($document, $subTotal)
    {
        $commissionFee = 0;
        $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
        if($isLoggedIn){
            $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        }else{
            $groupId = 0;
        }
        $tierCollection = Mage::getModel('document/tiercommission')->getCollection();
        $tierCollection
            ->addFieldToFilter('document_user_id', $document->getId())
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

    public function getDocumentFeeByInvoice($invoice)
    {
        $order = $invoice->getOrder();
        $documentId = $order->getDocumentId();
        $documentation = Mage::getModel('document/documentation')->load($documentId);
        $amount = $documentation->getPrice() + $order->getDocumentFee();
        return $amount;
    }

    public function getDocumentationFeeByQuote($quote)
    {
        $documentation = Mage::getSingleton('checkout/session')->getDocumentation();
        if($documentation){
            $documentationFee = $this->getDocumentationTotalFee($documentation, $quote->getSubtotal());
        }else{
            $documentationFee = 0;
        }
        return $documentationFee;
    }
}