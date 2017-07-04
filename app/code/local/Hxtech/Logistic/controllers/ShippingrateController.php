<?php

class Hxtech_Logistic_ShippingrateController extends Mage_Core_Controller_Front_Action
{
    protected function _getQuote()
    {
        return Mage::getSingleton('checkout/session')->getQuote();
    }
    
    public function setShippingrateAction()
    {
        $_params = $this->getRequest()->getParams();
        $quote = $this->_getQuote();
        $shippingrateId = $_params['id'];
        $shippingrate = Mage::getModel('logistic/shippingrate')->load($shippingrateId);
        
        // Start set logistic ID & shipping rate ID to quote        
        Mage::getSingleton('checkout/session')->setLogisticShippingrate($shippingrate);
        $logisticId = $shippingrate->getLogisticUserId();
        $quote->setShippingRateId($shippingrateId)->setLogisticId($logisticId)->save();
        // End set logistic ID & shipping rate ID to quote

        $html = Mage::app()->getLayout()->createBlock('logistic/checkout_total')->setTemplate('hxtech/logistic/checkout/total.phtml')->toHtml();

        $result = array();
        $result['forex_html'] = Mage::app()->getLayout()->createBlock('forex/financier_list')->setTemplate('hxtech/forex/checkout/list.phtml')->toHtml();
        $result['html'] = $html;
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}