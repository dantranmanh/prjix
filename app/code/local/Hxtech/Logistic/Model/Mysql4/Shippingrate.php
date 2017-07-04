<?php

class Hxtech_Logistic_Model_Mysql4_Shippingrate extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('logistic/shippingrate', 'id');
    }
}