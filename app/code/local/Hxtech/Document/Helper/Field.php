<?php

class Hxtech_Document_Helper_Field extends Mage_Core_Helper_Abstract
{
    public function getDocumentationOptions($field)
    {
        $options = array();

        // $options[0] = array("value" => "", "label" => "Please select an option");

        $collection = explode(',', Mage::getStoreConfig('document/documentation/'.$field));
        foreach($collection as $item){
            array_push($options, array("value" => $item, "label" => $item));
        }

        return $options;
    }

    public function getDocumentationGridOptions($field)
    {
        $options = array();

        $collection = explode(',', Mage::getStoreConfig('document/documentation/'.$field));
        foreach($collection as $item){
            $options[$item] = $item;
        }
        return $options;
    }

    public function getProducAttibuteOptions($attributeName)
    {
        $options = array();

        $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'product_food_category');
        $allOptions = $attribute->getSource()->getAllOptions(true, true);
        foreach ($allOptions as $instance) {
            if($instance["value"] != ""){
                array_push($options, $instance);
            }
        }
        return $options;
    }
}