<?php

class Hxtech_Logistic_Model_Logistic extends Mage_Core_Model_Abstract
{
    const LOGISTIC_ROLE_ID = 7;
    const LOGISTIC_ORDER_EMAIL_TEMPLATE = 'logistic_sales_email_order_template';
    const CUSTOMER_ORDER_EMAIL_TEMPLATE = 'customer_sales_email_order_template';
    const DOCUMENT_ORDER_EMAIL_TEMPLATE = 'document_sales_email_order_template';
    const COMMISSION_FIXED_TYPE = 1;
    const COMMISSION_PERCENTAGE_TYPE = 2;
    const COMMISSION_COMPARISON_TYPE = 3;

    public function getCommissionTypeOptions()
    {
    	return array(
    		self::COMMISSION_FIXED_TYPE => Mage::helper('logistic')->__('Fixed Fee (FF)'),
    		self::COMMISSION_PERCENTAGE_TYPE => Mage::helper('logistic')->__('Percentage (CM)'),
    		self::COMMISSION_COMPARISON_TYPE => Mage::helper('logistic')->__('Fixed minimum')
		);
    }
}