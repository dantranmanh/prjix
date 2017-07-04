<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Customers_CustomerTabs
    extends SafeMage_Permissions_Model_Plugin_Restrict_Categories_CatalogCategoryTabs
{
    /**
     * Customer Permissions of current admin
     *
     * @return SafeMage_Permissions_Model_Category
     */
    public function getPermissions()
    {
        $perm = $this->getSession()->getPermissions('customer');
        return $perm;
    }

    /**
     * Fix for standard Magento
     *
     * @param string $tab
     * @return string
     */
    protected function _fix($tab)
    {
        if ($tab == 'customer_edit_tab_view') {
            $tab = 'adminhtml/customer_edit_tab_view';
        }
        return $tab;
    }

    /**
     * Retrieve Tab label
     *
     * @param string|array $tab
     * @return string
     */
    protected function _getTabLabel($tab)
    {
        $label = null;

        if (isset($tab['label'])) {
            $label = $tab['label'];
        } else {
            $tab = $this->_fix($tab);

            if ($type = Mage::getBlockSingleton($tab)) {
                $label = $type->getTabLabel();
            }
        }

        return $label;
    }

}
