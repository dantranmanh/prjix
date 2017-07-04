<?php

class Hxtech_Barcode_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function isBarcodeImage($product, $image)
	{
		$imageFileAttribute = $image->getFile();

		$barcodeOuterImage = $product->getResource()->getAttribute('product_barcode_outer_image')->getFrontend()->getValue($product);
		$barcodeInnerImage = $product->getResource()->getAttribute('product_barcode_inner_image')->getFrontend()->getValue($product);
		$barcodeUnitImage = $product->getResource()->getAttribute('product_barcode_image')->getFrontend()->getValue($product);
		if($imageFileAttribute == $barcodeOuterImage || $imageFileAttribute == $barcodeInnerImage || $imageFileAttribute == $barcodeUnitImage){
			return true;
		}

		return false;
	}

	public function getBarcodeLabel($product, $image)
	{
		$imageFileAttribute = $image->getFile();

		$barcodeOuterImage = $product->getResource()->getAttribute('product_barcode_outer_image')->getFrontend()->getValue($product);
		$barcodeInnerImage = $product->getResource()->getAttribute('product_barcode_inner_image')->getFrontend()->getValue($product);
		$barcodeUnitImage = $product->getResource()->getAttribute('product_barcode_image')->getFrontend()->getValue($product);

		switch ($imageFileAttribute) {
			case $barcodeOuterImage:
				return 'Outer Barcode (EAN-13)';
				break;

			case $barcodeInnerImage:
				return 'Inner Barcode (EAN-13)';
				break;

			case $barcodeUnitImage:
				return 'Unit Barcode (EAN-13)';
				break;

			default:
				return '';
				break;
		}
	}


	public function generateBarcode($product, $type, $data, $imageType)
	{
		if(isset($data[$type]) && ($product->getData($imageType) == 'no_selection' || !$product->getData($imageType)) && strlen($data[$type]) > 11 && is_numeric($data[$type])){
        	$barcodeString = (strlen($data[$type]) > 12) ? substr($data[$type], 0, 12) : $data[$type];
        	// Only the text to draw is required
			$barcodeOptions = array(
				'text' => $barcodeString,
				'factor' => 1.2,
	            'barHeight' => 38,
	            'font' => 5,
			);

			// No required options
			$rendererOptions = array();

			// Draw the barcode in a new image,
			$barcodeImage = Zend_Barcode::draw(
			    'ean13', 'image', $barcodeOptions, $rendererOptions
			);
			$path = Mage::getBaseDir('media').DS."barcode".DS.$product->getId()."-".$type."-".$barcodeString.".png";

			$store_image = imagepng($barcodeImage,$path);

			if($store_image)
			{
			    try {
			    	$product->addImageToMediaGallery($path, $imageType, true, false);
			    } catch (Mage_Core_Exception $e){
			    	Mage::log($e->getMessage(), null, 'barcode.log', null);
			    	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			    }
			}
		}
	}
}