<?php

class Hxtech_Document_Model_Mysql4_Documentation_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
    public function _construct() {
        parent::_construct();
        $this->_init('document/documentation');
    }
}