<?php

class Hxtech_Logistic_Model_Port extends Mage_Core_Model_Abstract
{
    public function _construct() {
        parent::_construct();
        $this->_init('logistic/port');
    }
}