<?php

class Hxtech_Document_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getDocumentSupplierRoleId()
    {
        return Hxtech_Document_Model_Supplier::DOCUMENT_ROLE_ID;
    }

    public function isDocumentSupplierUser()
    {
        return Mage::getSingleton('admin/session')->getUser()->getIsDocumentUser();
    }

    public function isAdminUser()
    {
        return !Mage::getSingleton('admin/session')->getUser()->getIsDocumentUser();
    }

    public function getCurrentAdminUserId()
    {
        return Mage::getSingleton('admin/session')->getUser()->getId();
    }

    public function getProductAttribute($productId, $attributeName)
    {
        $_resource = Mage::getSingleton('catalog/product')->getResource();
        $optionValue = $_resource->getAttributeRawValue($productId, $attributeName, Mage::app()->getStore());
        return $optionValue;
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