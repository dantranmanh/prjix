<?php

class Hxtech_Logistic_Model_Mysql4_Importertier extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('logistic/importertier', 'id');
    }
}