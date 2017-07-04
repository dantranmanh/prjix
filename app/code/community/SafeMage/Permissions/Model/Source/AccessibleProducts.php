<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Source_AccessibleProducts
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => SafeMage_Permissions_Model_Product::ALLOW_ACCESS_TO_ALL,
                'label'=>Mage::helper('safemage_permissions')->__('All Products')
            ),
            array(
                'value' => SafeMage_Permissions_Model_Product::ALLOW_ACCESS_TO_CATEGORIES,
                'label'=>Mage::helper('safemage_permissions')->__('Products from Accessible Categories')
            ),
            array(
                'value' => SafeMage_Permissions_Model_Product::ALLOW_ACCESS_TO_SELECTED,
                'label'=>Mage::helper('safemage_permissions')->__('Selected Products')
            ),
            array(
                'value' => SafeMage_Permissions_Model_Product::ALLOW_ACCESS_TO_OWNED,
                'label'=>Mage::helper('safemage_permissions')->__('Owned Products')
            ),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            0 => Mage::helper('safemage_permissions')->__('No'),
            1 => Mage::helper('safemage_permissions')->__('Yes'),
        );
    }
}
