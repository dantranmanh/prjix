<?php

class Hxtech_Logistic_Block_Cms_Logistic extends Mage_Core_Block_Template
{
    protected $_collection;

    protected function _construct()
    {
        parent::_construct();
        $this->_collection = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('is_logistic_user', 1);
    }

    public function getLogisticCollection()
    {
        return $this->_collection;
    }
}
