<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Categories_StoreSwitcher
    extends SafeMage_Permissions_Model_Plugin_Restrict_StoreSwitcher
{
    /**
     * Category Permissions of current admin
     *
     * @return SafeMage_Permissions_Model_Category
     */
    public function getPermissions()
    {
        $perm = $this->getSession()->getPermissions('category');
        return $perm;
    }

    /**
     * Detect if this Store Switcher should be processed
     *
     * @param Mage_Adminhtml_Block_Store_Switcher
     * @return bool
     */
    protected function _detect($object)
    {
        $res = $this->getCategoriesClassHelper()->isCatalogCategoryStoreSwitcher($object);
        return $res;
    }
}
