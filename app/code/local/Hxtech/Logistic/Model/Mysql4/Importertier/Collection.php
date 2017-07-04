<?php

class Hxtech_Logistic_Model_Mysql4_Importertier_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
    public function _construct() {
        parent::_construct();
        $this->_init('logistic/importertier');
    }
}