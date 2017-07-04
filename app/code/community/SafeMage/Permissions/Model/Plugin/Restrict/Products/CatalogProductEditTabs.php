<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Products_CatalogProductEditTabs
    extends SafeMage_Permissions_Model_Plugin_Restrict_Products_Abstract
{
    /**
     * Hide disallowed tab
     *
     * @param Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs $object
     * @param bool $result
     * @param array $arguments
     * @return bool
     */
    public function afterCanShowTab($object, $result, array &$arguments)
    {
        if (isset($arguments[0])) {
            $tab = $arguments[0];

            if ($tabLabel = $this->_getTabLabel($tab)) {
                if ($perm = $this->getPermissions()) {
                    if (!$perm->isTabAllowed($tabLabel)) {
                        return false;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Retrieve Tab label
     *
     * @param Varien_Object $tab
     * @return string|null
     */
    protected function _getTabLabel($tab)
    {
        if ($tab->getLabel()) {
            return $tab->getLabel();

        // For 'Associated Products'
        } elseif ($tab->getType()) {
            $type = Mage::getBlockSingleton($tab->getType());
            return $type->getTabLabel();
        }

        return null;
    }
}
