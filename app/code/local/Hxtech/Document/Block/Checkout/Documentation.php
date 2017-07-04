<?php

class Hxtech_Document_Block_Checkout_Documentation extends Mage_Core_Block_Template
{
    protected $_collection;

    protected function _construct()
    {
        parent::_construct();
        $this->_collection = Mage::getModel('document/documentation')->getCollection()->addFieldToFilter('status', 1);
        $isFilterEnable = Mage::getStoreConfig('document/documentation/filter_enabled');
        if($isFilterEnable){
            $this->_filterByExportingCountry();
            $this->_filterByImportingCountry();
            // $this->_filterByFoodCategory(); #188 Show all rates from document supplier to customer
        }
    }

    public function getCollection()
    {
        return $this->_collection;
    }

    protected function _filterByExportingCountry()
    {

    }

    protected function _filterByImportingCountry()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $billingAddress = $quote->getBillingAddress();
        $countryId = $billingAddress->getCountryId();
        if($countryId){
            $importingDocIds = Mage::helper('document/documentation')->getImportingDocIds($this->_collection, $countryId);
            $this->_collection->addFieldToFilter('id', array('in' => $importingDocIds));
        }
    }   

    protected function _filterByFoodCategory()
    {
        $isDairyProductExist = Mage::helper('document/documentation')->isDairyProductExist();
        if($isDairyProductExist){
            $this->_collection->addFieldToFilter('id', 1);
        }else{
            $this->_collection->addFieldToFilter('id', 2);
        }
    }
}
