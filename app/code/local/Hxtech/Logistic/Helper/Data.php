<?php

class Hxtech_Logistic_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function renameImage($image_name) {
        $string = str_replace("  ", " ", $image_name);
        $new_image_name = str_replace(" ", "-", $string);
        $new_image_name = strtolower($new_image_name);
        return $new_image_name;
    }

    public function getProductAttribute($productId, $attributeName)
    {
		$_resource = Mage::getSingleton('catalog/product')->getResource();
		$optionValue = $_resource->getAttributeRawValue($productId, $attributeName, Mage::app()->getStore());
		return $optionValue;
    }

    public function getLogisticAverageStars($logisticId)
    {
        $collection = Mage::getModel('logistic/review')->getCollection();
        $collection->getSelect()
                ->columns('SUM(number_star)/COUNT(*) as average_star')
                ->group('logistic_user_id');
        $collection->addFieldToFilter('logistic_user_id', $logisticId);

        $row = $collection->getFirstItem();

        if(count($row->getData()) > 0){
            return $row->getAverageStar();
        }else{
            return 0;
        }
    }

    public function getContainerSpecification()
    {
        $result = array();

        $configValues = explode(',',Mage::getStoreConfig('logistic/shippingrate/container_specifications'));
        if (count($configValues) > 0) {
            $result['20ft'] = $this->removeNonNumericFromString(trim(explode('-', $configValues[0])[1]));
            $result['40ft'] = $this->removeNonNumericFromString(trim(explode('-', $configValues[1])[1]));
        }
        return $result;
    }

    public function removeNonNumericFromString($string)
    {
        return preg_replace("/[^0-9,.]/", "", $string);
    }

    public function getCommisionNameByType($type)
    {
        switch ($type) {
            case Hxtech_Logistic_Model_Logistic::COMMISSION_FIXED_TYPE:
                $name = Mage::helper('logistic')->__('Fixed Fee (FF)');
                break;
            case Hxtech_Logistic_Model_Logistic::COMMISSION_PERCENTAGE_TYPE:
                $name = Mage::helper('logistic')->__('Percentage (CM)');
                break;
            case Hxtech_Logistic_Model_Logistic::COMMISSION_COMPARISON_TYPE:
                $name = Mage::helper('logistic')->__('Fixed minimum');
                break;
            default:
                $name = "";
                break;
        }
        return $name;
    }

    /**
     * Exception logging
     *
     * @param Exception $e
     * @return void
     */
    public function exception(Exception $e)
    {
        Mage::log("\n" . $e->__toString(), Zend_Log::ERR, strtolower($this->_getModuleName()) . '-exception.log');
    }
}