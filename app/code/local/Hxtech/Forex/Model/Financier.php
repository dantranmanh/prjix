<?php

class Hxtech_Forex_Model_Financier extends Mage_Core_Model_Abstract
{
    public function _construct() 
    {
        parent::_construct();
        $this->_init('forex/financier');
    }

    public function sendOrderEmail($order)
    {
    	$emailTemplate = Mage::getModel('core/email_template');
    	$emailTemplate->sendTransactional(
            $this->getEmailTemplateId(),
            Mage::getStoreConfig('sales_email/order/identity', 0),
            $this->getEmail(),
            $this->getName(),
            array()
        );
    }
}