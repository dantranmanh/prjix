<?php

class Hxtech_Document_Model_Documentation extends Mage_Core_Model_Abstract
{
    public function _construct() {
        parent::_construct();
        $this->_init('document/documentation');
    }
}