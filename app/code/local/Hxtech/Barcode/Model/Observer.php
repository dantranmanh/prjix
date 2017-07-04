<?php

class Hxtech_Barcode_Model_Observer
{
	public function generateBarcode($observer)
    {	
    	$_product = $observer->getEvent()->getProduct();
        $_params = Mage::app()->getRequest()->getParams();
        $data = $_params['product'];
        if(isset($_params['product'])){
        	$data = $_params['product'];
	        Mage::helper('barcode')->generateBarcode($_product, 'product_barcode_unit', $data, 'product_barcode_image');
	        Mage::helper('barcode')->generateBarcode($_product, 'product_barcode_inner', $data, 'product_barcode_inner_image');
	        Mage::helper('barcode')->generateBarcode($_product, 'product_barcode_outer', $data, 'product_barcode_outer_image');
        }
    }  
}