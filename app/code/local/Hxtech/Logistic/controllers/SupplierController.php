<?php

class Hxtech_Logistic_SupplierController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout()->renderLayout();
    }

    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }

    public function registerPostAction()
    {
    	$session = $this->_getSession();
    	if ($data = $this->getRequest()->getPost()) {
            $accountType = $data['account_type'];
            if($accountType == 1){ //logistic Supplier 
                $data['is_logistic_user'] = 1;
                $uRoles = array(Mage::helper('logistic/logistic')->getLogisticRoleId());
            }elseif($accountType == 2){ //Documentation Supplier
                $data['is_document_user'] = 1;
                $uRoles = array(Mage::helper('document')->getDocumentSupplierRoleId());
            }
            
            $data['is_active'] = 0;
            $model = Mage::getModel('admin/user');
            if (isset($_FILES['logistic_logo']['name']) && $_FILES['logistic_logo']['name'] != '') {
                try {
                    //rename image in case image name has space
                    $image_name = $_FILES['logistic_logo']['name'];
                    $new_image_name = Mage::helper('logistic')->renameImage($image_name);

                    $uploader = new Varien_File_Uploader('logistic_logo');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(TRUE);
                    $uploader->setFilesDispersion(FALSE);

                    $path = Mage::getBaseDir('media') . DS . 'logistic' . DS . 'logo';
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }

                    if (!file_exists($path . DS . $new_image_name)) {
                        $uploader->save($path, $new_image_name);
                    }
                } catch (Exception $e) {
                    $session->addError($e->getMessage());
                }
                $data['logistic_logo'] = $new_image_name;
            }
            $model->setData($data);

            /*
             * Unsetting new password and password confirmation if they are blank
             */
            if ($model->hasNewPassword() && $model->getNewPassword() === '') {
                $model->unsNewPassword();
            }
            if ($model->hasPasswordConfirmation() && $model->getPasswordConfirmation() === '') {
                $model->unsPasswordConfirmation();
            }

            try {
                $model->save();
                
                $model->setRoleIds($uRoles)
                    ->setRoleUserId($model->getUserId())
                    ->saveRelations();

                $session->addSuccess($this->__('Thank you for your submission. Your application will be reviewed and if successful you will be notified via email.'));

                $this->_redirectUrl(Mage::getBaseUrl());
                return;
            } catch (Mage_Core_Exception $e) {
                $session->addError($e->getMessage());
                $this->_redirectUrl(Mage::getBaseUrl());
                return;
            }
        }
        $this->_redirectUrl(Mage::getBaseUrl());
    }

    public function reloadProductPriceAction()
    {
        $result = array();
        $_params = $this->getRequest()->getParams();
        $productId = $_params['productId'];
        $product = Mage::getModel('catalog/product')->load($productId);
        $productType = $_params['productType'];
        if($productType == "pallet"){
            $totalQty = Mage::helper('logistic/logistic')->getQtyByPallet($product, 1);
        }else{
            $totalQty = 1;
        }
        $_store = $product->getStore();
        $_convertedPrice = $_store->roundPrice($_store->convertPrice($product->getPrice()));
        $_convertedFinalPrice = $_store->roundPrice($_store->convertPrice($product->getFinalPrice()));
        $_basePrice = Mage::helper('tax')->getPrice($product, $_convertedPrice);
        $_finalPrice = Mage::helper('tax')->getPrice($product, $_convertedFinalPrice);

        $price = $_finalPrice * $totalQty;
        $priceHtml = '<span class="price">'.Mage::helper('core')->currency($price, true, false).'</span>';

        if($_finalPrice < $_basePrice){
            $result['base_price'] = Mage::helper('core')->formatPrice($_basePrice * $totalQty, false);
        }else{
            $result['base_price'] = false;
        }
        
        $result['qty'] = $totalQty;
        $result['units'] = Mage::helper('logistic/logistic')->getProductUnit($product, $productType);
        $result['html'] = $priceHtml;
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function reloadClosestPortAction()
    {
        $result = array();
        $html = '';
        $_params = $this->getRequest()->getParams();
        $countryId = $_params['countryId'];
        $addressId = $_params['addressId'];

        if($addressId){
            $currentAddress = Mage::getModel('customer/address')->load($addressId);
            $currentClosestPort = $currentAddress->getClosestportName();
        }else{
            $currentClosestPort = "";
        }

        $model = Mage::getModel('logistic/port');
        $options = $model->getCollection()->addFieldToFilter('country_code', $countryId);

        $html .= '<select name="closestport_name" class="validate-select" id="closestport_name">';
        $html .= '<option value="">Please select an option</option>';
        foreach($options as $option){
            $selected = ($option->getPort() == $currentClosestPort) ? 'selected = "selected"' : '';
            $html .= '<option '.$selected.' value="'.$option->getPort().'">'.$option->getPort().'</option>';
        }
        $html .= '</select>';

        $result['html'] = $html;
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function reloadContainerSectionAction()
    {
        $result = array();
        $_params = $this->getRequest()->getParams();
        $qty = $_params['qty'];
        $productId = $_params['productId'];
        $palletId = $this->getRequest()->getParam('palletId');
        if(!isset($palletId) || $palletId == ""){
            $result['html'] = "";
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
            return $this;
        }
        $pallet = Mage::getModel('logistic/pallet')->load($palletId);
        $product = Mage::getModel('catalog/product')->load($productId);
        
        $totalCbm = $qty * Mage::helper('logistic')->getProductAttribute($productId, 'product_case_volume');
        $palletCbm = Mage::helper('logistic/pallet')->getPalletCbm($pallet);
        $palletsPer20ft = $pallet->getNumberFitSmallContainer();
        $palletsPer40ft = $pallet->getNumberFitLargeContainer();
        if(isset($_params['type']) && $_params['type'] == "pallet"){
            // $qty = $qty * $product->getProductCasesPerPallet();
            $palletUsed = $qty;
        }else{
            $palletUsed = ceil($totalCbm/$palletCbm);
        }
        $number40ft = floor($palletUsed / $palletsPer40ft); //qty of 40ft container
        $remain = $palletUsed - $number40ft * $palletsPer40ft;

        $number20ft = 0;
        $percent = 100;
        if($remain > $palletsPer20ft){
            // set number 40ft container = 1 if there is no 20 ft container
            $number40ft = ($number40ft >= 1) ? $number40ft : 1;
            if($remain > 0){
                $percent = $remain / $palletsPer40ft;
            }
        }else{
            if($remain > 0){
                $number20ft = 1;
                $percent = $remain / $palletsPer20ft; 
            }
        }

        $html = Mage::app()->getLayout()->createBlock('core/template')
        	->setTemplate('hxtech/logistic/product/container.phtml')
            ->setTotalCbm($totalCbm)
            ->setPalletUsed($palletUsed)
        	->setNumber40ft($number40ft)
        	->setNumber20ft($number20ft)
        	->setPercent(number_format($percent * 100, 1, '.', ''))
        	->toHtml();
        $result['html'] = $html;
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}