<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Source_AccessibleCategories
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
                'value' => SafeMage_Permissions_Model_Category::ALLOW_ACCESS_TO_ALL,
                'label'=>Mage::helper('safemage_permissions')->__('All Categories')
            ),
            array(
                'value' => SafeMage_Permissions_Model_Category::ALLOW_ACCESS_TO_SELECTED,
                'label'=>Mage::helper('safemage_permissions')->__('Selected Categories')
            ),
        );
    }
}
