<?php

class Hxtech_Barcode_IndexController extends Mage_Core_Controller_Front_Action
{
	public function testAction()
	{
		$barcodeOptions = array(
            'text' => 012301230123,
            'factor' => 1.2,
            'barHeight' => 38,
            'font' => 5,
        );

        // No required options
        $rendererOptions = array();

        // Draw the barcode in a new image,
        $barcodeImage = Zend_Barcode::render(
            'ean13', 'image', $barcodeOptions, $rendererOptions
        );
        zend_debug::dump($barcodeImage);die;
	}

    protected function _getQuote()
    {
        return Mage::getSingleton('checkout/session')->getQuote();
    }

    public function printBarcodeCartAction()
    {
        $quote = $this->_getQuote();
        Mage::getModel('barcode/pdf_cart')->renderPdf($quote);
    }
}