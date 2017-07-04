<?php

class Hxtech_Forex_Model_Source_Option extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
                array(
                    "label" => Mage::helper('forex')->__('Please select an option'),
                    "value" => ""
                ),
                array(
                    "label" => Mage::helper('forex')->__('USD'),
                    "value" => "USD"
                ),
                array(
                    "label" => Mage::helper('forex')->__('EUR(Euro)'),
                    "value" => "EUR"
                )
            );

            if (Mage::app()->getStore()->isAdmin() && Mage::app()->getRequest()->getControllerName() == 'customer') {
                $requestCustomerId = Mage::app()->getRequest()->getParam('id');
                if($requestCustomerId){
                    $customer = Mage::getModel('customer/customer')->load($requestCustomerId);
                }
            }

            $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
            if($isLoggedIn){
                $customer = Mage::getSingleton('customer/session')->getCustomer();
            }
            if(isset($customer)){
                $address = $customer->getPrimaryBillingAddress();
                if($address){
                    $countryId = $address->getCountryId();
                    $currencyCode = Mage::helper('forex/currency')->getCurrencyByCountryCode($countryId);
                    if($currencyCode != "USD" && $currencyCode != "EUR"){
                        $this->_options[] = array(
                            "label" => $currencyCode,
                            "value" => $currencyCode
                        );
                    }
                }
            }
            
            // $allowCurrencies = explode(',', Mage::getStoreConfig('currency/options/allow'));
            // foreach($allowCurrencies as $currency){
            //     $this->_options[] = array(
            //         "label" => Mage::helper('forex')->__($currency),
            //         "value" => $currency
            //     );
            // }
        }
        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = array();
        foreach ($this->getAllOptions() as $option) {
            $_options[$option["value"]] = $option["label"];
        }
        return $_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();
        foreach ($options as $option) {
            if ($option["value"] == $value) {
                return $option["label"];
            }
        }
        return false;
    }
}