<?php

class Hxtech_Forex_Model_Observer
{
	public function financierOrderProcess($observer)
	{
		$quote = Mage::getSingleton('checkout/session')->getQuote();
        $order = $observer->getOrder();
        $financierId = $quote->getFinancierId();
        if($financierId){
        	$financier = Mage::getModel('forex/financier')->load($financierId);
        	$financier->sendOrderEmail($order);
        }
	}
}