<?php

class Hxtech_Logistic_Block_Checkout_Shippingrate extends Mage_Core_Block_Template
{
    protected $_collection;
    protected $_closestPort;
    protected $_originPort;

    protected function _construct()
    {
        parent::_construct();
        $this->_collection = Mage::getModel('logistic/shippingrate')->getCollection();
        $this->_filterContainerByClosestCity();
        $this->_filterContainerByDestinationCountry();
        $this->_filterContainerByClosestPort();
        $this->_filterContainerByCbm();
    }

    public function getCollection()
    {
        return $this->_collection;
    }

    public function getClosestPort()
    {
        return $this->_closestPort;
    }

    public function getOriginPort()
    {
        return $this->_originPort;
    }

    public function getShippingrateId()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        return $quote->getShippingRateId();
    }

    protected function _filterContainerByClosestCity()
    {

    }

    protected function _filterContainerByDestinationCountry()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $billingAddress = $quote->getBillingAddress();
        $countryCode = $billingAddress->getCountryId();
        $this->_collection->addFieldToFilter('destination_country', $countryCode);
    }

    protected function _filterContainerByClosestPort()
    {
        if(Mage::getSingleton('customer/session')->isLoggedIn()){
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $billingAddress = $customer->getPrimaryBillingAddress();
            $closestPort = $billingAddress->getClosestportName();
            $this->_closestPort = $closestPort;
            $this->_collection->addFieldToFilter('destination_port',array('finset'=>array($closestPort)));
        }
    }

    protected function _filterContainerByCbm()
    {
        $totalCbm = Mage::helper('logistic/logistic')->getTotalCbm();
        if ($totalCbm < 33) {
            $this->_collection->addFieldToFilter('container_size', 'LCL');
        } elseif ((33 <= $totalCbm) && ($totalCbm < 67.3)){
            $this->_collection->addFieldToFilter('container_size', 'FCL-40');
        }else{
            $this->_collection->addFieldToFilter('container_size', 'FCL-40HQ');
        }
    }
}
