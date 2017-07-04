<?php

class Hxtech_Document_Model_Mysql4_Documentation extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('document/documentation', 'id');
    }
}