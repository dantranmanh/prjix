<?php

class Hxtech_Logistic_Helper_Field extends Mage_Core_Helper_Abstract
{
    protected function _formatFieldValue($value)
    {
        return preg_replace('/\s+/', '', $value);
    }

    public function getShippingRateOptions($field)
    {
        $options = array();

        $options[0] = array("value" => "", "label" => "Please select an option");

        $collection = explode(',', Mage::getStoreConfig('logistic/shippingrate/'.$field));
        foreach($collection as $item){
            $item = $this->_formatFieldValue($item);
            if($item == "") continue;
            array_push($options, array("value" => $item, "label" => $item));
        }
        return $options;
    }

    public function getShippingRateGridOptions($field)
    {
        $options = array();

        $collection = explode(',', Mage::getStoreConfig('logistic/shippingrate/'.$field));
        foreach($collection as $item){
            $item = $this->_formatFieldValue($item);
            if($item == "") continue;
            $options[$item] = $item;
        }
        return $options;
    }

    public function getPortOptions($countryCode)
    {
        $options = array();

        $options[0] = array("value" => "", "label" => "Please select an option");
        if($countryCode != ""){
            $collection = Mage::getModel('logistic/port')->getCollection()->addFieldToFilter('country_code', $countryCode);
            foreach($collection as $item){
                array_push($options, array("value" => $item->getPort(), "label" => $item->getPort()));
            }
        }
        
        return $options;
    }

    public function getPortGridOptions()
    {
        $options = array();

        $collection = Mage::getModel('logistic/port')->getCollection();
        foreach($collection as $item){
            $options[$item->getPort()] = $item->getPort();
        }
        return $options;
    }
}