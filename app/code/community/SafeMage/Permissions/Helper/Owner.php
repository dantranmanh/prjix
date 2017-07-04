<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Owner extends Mage_Core_Helper_Abstract
{
    public function isProductCreated($product, $requestUri)
    {
        if ((!$product->getEntityId()) && stristr($requestUri, '/catalog_product/save')) {
            return true;
        }

        return false;
    }

    public function add($product, $admin)
    {
        $attrCode = Mage::getResourceModel('safemage_permissions/attribute_owner')->getCode();
        $owners = $product->getData($attrCode);
        $owners = is_array($owners) ? $owners : array();

        if (!in_array($admin->getUserId(), $owners)) {
            $owners[]= $admin->getUserId();
            $product->setData($attrCode, $owners);
        }
    }
}