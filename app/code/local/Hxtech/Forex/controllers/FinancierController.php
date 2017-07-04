<?php

class Hxtech_Forex_FinancierController extends Mage_Core_Controller_Front_Action
{
    protected function _getQuote()
    {
        return Mage::getSingleton('checkout/session')->getQuote();
    }

    public function setFinancierAction()
    {
    	$result = array();
        $_params = $this->getRequest()->getParams();
        $quote = $this->_getQuote();

        $financierId = $_params['id'];
        try {
        	$quote->setFinancierId($financierId)->save();
        } catch (Exception $e) {
        	Mage::logException($e->getMessage());
        }
        
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}
