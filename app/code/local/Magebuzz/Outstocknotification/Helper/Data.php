<?php
/*
* @copyright   Copyright (c) 2014 www.magebuzz.com
*/ 
class Magebuzz_Outstocknotification_Helper_Data extends Mage_Core_Helper_Abstract {
  public function getnotifyUrl() {
    return Mage::getUrl('outstocknotification/index/stoctnotify');
  }

  public function outStockTemplate() {
    if ($this->enableModule() && $this->showCategoryButton()) {
      return 'outstocknotification/catalog/product/list.phtml';
    }
    else {
      return 'catalog/product/list.phtml';
    }
  }

  public function enableModule() {
    return (bool) Mage::getStoreConfig('outstocknotification/general/module_enable');
  }

  public function showCategoryButton() {
    return (bool) Mage::getStoreConfig('outstocknotification/general/showbutton');
  }

  public function getProductOptionsHtml(Mage_Catalog_Model_Product $product,$itemId) {
    $text = '';      
    if($product->getTypeId()=="configurable") {
      $blockViewType = Mage::getBlockSingleton('Magebuzz_Outstocknotification_Block_Product_View_Type_Configurable');      
      $blockViewType->setProduct($product);
      $text = array();
      $json =  json_decode($blockViewType->getJsonConfig());      
      foreach($json->attributes as $js){
        $option = $js->options ; 
        $label = $js->label ;
        //Zend_Debug::dump();die();
        foreach($option as $op){        
          $productId = $op->products ;
          if(!in_array($itemId,$productId)){
            continue;
          }else{
            $text[] = $label.' : '.$op->label;
          }
        }
      }
      if(!empty($text)){
        $text = '( ' .implode(' , ',$text). ' )';
      } 
    }else{
      $productModel = Mage::getModel('catalog/product')->load($itemId) ;
      $text = $productModel->getName() ;
    }  
    return $text;
  }
  public function getCustomer(){

    $customer = array('firstname'=>'','lastname'=>'','email'=>'');
    $session = Mage::getModel('customer/session'); 
    if($session->isLoggedIn()) {
      $customer = $session->getCustomer()->getData();
    }
    return $customer ;
  }
}