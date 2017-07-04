<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Categories_CatalogCategoryTabs
    extends SafeMage_Permissions_Model_Plugin_Restrict_Categories_Abstract
{
    /**
     * Remove disallowed Tab
     *
     * @param Mage_Adminhtml_Block_Catalog_Category_Tabs $object
     * @param Mage_Adminhtml_Block_Catalog_Category_Tabs $result
     * @param array $arguments
     * @return Mage_Adminhtml_Block_Catalog_Category_Tabs
     */
    public function afterAddTab($object, $result, array &$arguments)
    {
        if (isset($arguments[0]) && isset($arguments[1])) {
            $tabId = $arguments[0];
            $tab = $arguments[1];

            if ($tabLabel = $this->_getTabLabel($tab)) {
                if ($perm = $this->getPermissions()) {
                    if (!$perm->isTabAllowed($tabLabel)) {
                        $object->removeTab($tabId);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Set active Tab
     *
     * @param Mage_Adminhtml_Block_Catalog_Category_Tabs $tabs
     */
    public function correctActiveTab($tabs)
    {
        $tabIds = $tabs->getTabsIds();
        $tabActiveFromState = $this->getActiveTabFromState($tabs);

        // Set 1st tab as active if Unknown tab in current state
        if (!in_array($tabActiveFromState, $tabIds)) {
            if (count($tabIds)) {
                $tabActive = current($tabIds);
                $tabs->setActiveTab($tabActive);
            }
        }
    }

    /**
     * Get active Tab from session or from POST
     *
     * @param Mage_Adminhtml_Block_Catalog_Category_Tabs $tabs
     * @return string
     */
    public function getActiveTabFromState($tabs)
    {
        $activeTabId = null;
        if (!$activeTabId = Mage::app()->getRequest()->getParam('active_tab')) {
            $activeTabId = Mage::getSingleton('admin/session')->getActiveTabId();
        }

        if ($activeTabId) {
            $activeTabId = str_replace($tabs->getId() . '_', '',$activeTabId);
        }

        return $activeTabId;
    }

    protected function _getTabLabel($tab)
    {
        $label = isset($tab['label']) ? $tab['label'] : null;
        return $label;
    }
}
