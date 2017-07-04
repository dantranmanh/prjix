<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

abstract class SafeMage_Permissions_Model_Plugin_Restrict_Abstract
{
    /**
     * Permissions of current admin
     *
     * @return SafeMage_Permissions_Model_Abstract
     */
    abstract public function getPermissions();

    /**
     * @return SafeMage_Permissions_Model_Resource_Restrict_Products
     */
    public function getProductsRestrictor()
    {
        return Mage::getResourceModel('safemage_permissions/restrict_products');
    }

    /**
     * @return SafeMage_Permissions_Helper_Class_Categories
     */
    public function getCategoriesClassHelper()
    {
        return Mage::helper('safemage_permissions/class_categories');
    }

    /**
     * @return SafeMage_Permissions_Helper_Class_Products
     */
    public function getProductsClassHelper()
    {
        return Mage::helper('safemage_permissions/class_products');
    }

    /**
     * @return SafeMage_Permissions_Helper_Class_Sales
     */
    public function getSalesClassHelper()
    {
        return Mage::helper('safemage_permissions/class_sales');
    }

    /**
     * @return SafeMage_Permissions_Helper_Class_Customers
     */
    public function getCustomersClassHelper()
    {
        return Mage::helper('safemage_permissions/class_customers');
    }

    /**
     * @return SafeMage_Permissions_Helper_Class_Config
     */
    public function getConfigClassHelper()
    {
        return Mage::helper('safemage_permissions/class_config');
    }

    /**
     * @return SafeMage_Permissions_Helper_Request
     */
    public function getRequestHelper()
    {
        return Mage::helper('safemage_permissions/request');
    }

    /**
     * @return SafeMage_Permissions_Helper_Form
     */
    public function getFormHelper()
    {
        return Mage::helper('safemage_permissions/form');
    }

    /**
     * @return SafeMage_Permissions_Model_Role_Session
     */
    public function getSession()
    {
        return Mage::getSingleton('safemage_permissions/role_session');
    }

    /**
     * @return SafeMage_Permissions_Model_Resource_Core
     */
    public function getCoreResource()
    {
        return Mage::getResourceModel('safemage_permissions/core');
    }


    protected function _getSourceConfigSections()
    {
        return Mage::getSingleton('safemage_permissions/Source_AccessibleConfigSections');
    }

    /**
     * Detect if Plugin can be executed
     *
     * @return bool
     */
    public function canRun()
    {
        $isAdmin = Mage::app()->getStore()->isAdmin();
        $perm = $this->getPermissions();
        return $isAdmin && $perm;
    }
}
