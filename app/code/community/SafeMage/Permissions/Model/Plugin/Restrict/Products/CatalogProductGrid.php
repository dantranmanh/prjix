<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Products_CatalogProductGrid
    extends SafeMage_Permissions_Model_Plugin_Restrict_Products_Abstract
{
    /**
     * Hide disallowed Products
     *
     * @param Mage_Adminhtml_Block_Widget_Grid $object
     * @param Varien_Data_Collection $result
     * @param array $arguments
     * @return Varien_Data_Collection
     */
    public function afterSetCollection($object, $result, array $arguments)
    {
        if ($perm = $this->getPermissions()) {
            $this->getProductsRestrictor()->catalogProductGridCollection($object->getCollection(), $perm);
        }

        return $object;
    }
}
