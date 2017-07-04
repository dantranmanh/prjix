<?php

class Hxtech_Logistic_Model_Mysql4_Pallet extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('logistic/pallet', 'id');
    }
}