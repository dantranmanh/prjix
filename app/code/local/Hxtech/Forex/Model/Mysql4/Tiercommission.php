<?php

class Hxtech_Forex_Model_Mysql4_Tiercommission extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('forex/tiercommission', 'id');
    }
}