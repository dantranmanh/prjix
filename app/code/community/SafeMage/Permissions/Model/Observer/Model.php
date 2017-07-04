<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Observer_Model
{
    public function getRequestHelper()
    {
        return Mage::helper('safemage_permissions/request');
    }

    public function onModelSaveBefore(Varien_Event_Observer $observer)
    {
        $object = $observer->getObject();
        if ($object instanceof Mage_Catalog_Model_Product) {

            if (Mage::helper('safemage_permissions/config')->isOwnerEnabled()) {

                if (Mage::helper('safemage_permissions/owner')->isProductCreated(
                    $object,
                    Mage::app()->getRequest()->getRequestUri())
                ) {
                    $admin = Mage::getSingleton('admin/session')->getUser();
                    Mage::helper('safemage_permissions/owner')->add($object, $admin);
                }
            }
        }
    }

    public function onModelSaveAfter(Varien_Event_Observer $observer)
    {
	    $object = $observer->getObject();
        $hRequest = Mage::helper('safemage_permissions/request');

        if ($object instanceof Mage_Admin_Model_User) {
            if (Mage::helper('safemage_permissions/config')->isOwnerEnabled()) {
                $params = Mage::app()->getRequest()->getParams();

                if (array_key_exists($hRequest->getUserOwnedProductsVarName(), $params)) {
                    $sOwnedProducts = $params[$hRequest->getUserOwnedProductsVarName()];
                    $ownedProducts = explode(',', $sOwnedProducts);
                    Mage::getResourceModel('safemage_permissions/attribute_owner')->updateOwnedProductIds($object, $ownedProducts);
                }
            }
        }

        if ($object instanceof Mage_Admin_Model_Roles) {
            if ($object->getRoleId()) {
                $role = Mage::getModel('safemage_permissions/role')->load($object->getRoleId());

                $prodVarName = Mage::helper('safemage_permissions/request')->getProductsVarName();
                $catVarName = Mage::helper('safemage_permissions/request')->getCategoriesVarName();
                $custVarName = Mage::helper('safemage_permissions/request')->getCustomersVarName();
                $confVarName = Mage::helper('safemage_permissions/request')->getConfigVarName();


                if ($data = Mage::app()->getRequest()->getParam($catVarName)) {
                    $catGridType = $this->getRequestHelper()->getCategoriesGridType();
                    $data['a']= Mage::app()->getRequest()->getParam($catGridType);
                    $role->setPermissions('category', $data);
                }

                if ($data = Mage::app()->getRequest()->getParam($prodVarName)) {
                    $prodGridType = $this->getRequestHelper()->getProductsGridType();
                    $data['a']= Mage::app()->getRequest()->getParam($prodGridType);
                    $role->setPermissions('product', $data);
                }

                if ($data = Mage::app()->getRequest()->getParam('sales')) {
                    $role->setPermissions('sale', $data);
                }

                if ($data = Mage::app()->getRequest()->getParam($custVarName)) {
                    $custGridType = $this->getRequestHelper()->getCustomersGridType();
                    $data['a']= Mage::app()->getRequest()->getParam($custGridType);
                    $role->setPermissions('customer', $data);
                }

                if ($data = Mage::app()->getRequest()->getParam($confVarName)) {
                    $confGridType = $this->getRequestHelper()->getConfigGridType();
                    $data['a']= Mage::app()->getRequest()->getParam($confGridType);
                    $role->setPermissions('config', $data);
                }
            }
        }
    }
}
