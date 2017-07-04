<?php
/*
* @copyright   Copyright (c) 2014 www.magebuzz.com
*/ 
class Magebuzz_Outstocknotification_Model_Outstocknotification extends Mage_Core_Model_Abstract {
  public function _construct() {
    parent::_construct();
    $this->_init('outstocknotification/outstocknotification');
  }
  public function addDataNotify($isArray) {

    if($isArray) {
      $pId   = $isArray['productid'];
      $pName = Mage::getModel('catalog/product')->load($pId)->getName();
      $website_id = Mage::app()->getStore()->getWebsiteId();
      if (isset($isArray['firstname'])) {
        $fName = $isArray['firstname'];
      }
      else {
        $fName = 'Guest';
      }
      if (isset($isArray['lastname'])) {
        $lName  = $isArray['lastname'];
      }
      else {
        $lName = 'Guest';
      }

      $email = $isArray['email'];
      $customer_id = $isArray['customer_id'];      
      $alertModel = Mage::getModel('productalert/stock')->getCollection()->addFieldToFilter('product_id',$pId)->addFieldToFilter('email',$email)->addFieldToFilter('status',0)->getData();
      if(!empty($alertModel)){
        return false;
      }else{
        $date = now();
        $data = array('product_id'=>$pId,'website_id'=>$website_id,'add_date'=>$date,'email'=>$email,'firstname'=>$fName,'lastname'=>$lName,'customer_id'=>$customer_id) ;
        $model = Mage::getModel('productalert/stock')->setData($data);      
        try{
          $model->save();
//          Mage::getSingleton('core/session')->addSuccess($pName.' has been added');
          return true;
        }catch(Exception $e){         
        }
        return false;    
      }			
    }//if end hear
    else{
      return false;
    }
  }

  public function addDataNotifyAfterLogin($isArray) {

    if($isArray) {
      $pId   = $isArray['productid'];
      $website_id = Mage::app()->getStore()->getWebsiteId();
      if (isset($isArray['firstname'])) {
        $fName = $isArray['firstname'];
      }
      else {
        $fName = 'Guest';
      }
      if (isset($isArray['lastname'])) {
        $lName  = $isArray['lastname'];
      }
      else {
        $lName = 'Guest';
      }

      $email = $isArray['email'];
      $customer_id = $isArray['customer_id'];
      $alertModel = Mage::getModel('productalert/stock')->getCollection()->addFieldToFilter('product_id',$pId)->addFieldToFilter('email',$email)->addFieldToFilter('status',0)->getData();
      if(!empty($alertModel)){

      }else{
        $date = now();
        $data = array('product_id'=>$pId,'website_id'=>$website_id,'add_date'=>$date,'email'=>$email,'firstname'=>$fName,'lastname'=>$lName,'customer_id'=>$customer_id) ;
        $model = Mage::getModel('productalert/stock')->setData($data);
        try{
          $model->save();

        }catch(Exception $e){
        }

      }
    }//if end hear
    else{

    }
  }
}