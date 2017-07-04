<?php

class Hxtech_Logistic_Block_Checkout_Total extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
    }

    public function isShowImporterFee()
    {
    	return Mage::helper('logistic/importer')->isShowImporterFee();
    }
}
