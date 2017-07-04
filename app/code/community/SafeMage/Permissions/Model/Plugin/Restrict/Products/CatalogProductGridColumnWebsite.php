<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Products_CatalogProductGridColumnWebsite
extends SafeMage_Permissions_Model_Plugin_Restrict_GridColumn
{
    /**
     * Product Permissions of current admin
     *
     * @return SafeMage_Permissions_Model_Product
     */
    public function getPermissions()
    {
        $perm = $this->getSession()->getPermissions('product');
        return $perm;
    }

    /**
     * Detect if this Grid should be processed
     *
     * @param Mage_Adminhtml_Block_Catalog_Product_Grid
     * @return bool
     */
    protected function _detect($object)
    {
        $res = $this->getProductsClassHelper()->isCatalogProductGrid($object);
        return $res;
    }

    /**
     * Detect if this Grid Column should be processed
     *
     * @param int $columnId
     * @return bool
     */
    protected function _detectId($columnId)
    {
        $res = ($columnId == 'websites') ? true : false;
        return $res;
    }

    /**
     * Modify Grid Column
     *
     * @param array $column
     */
    protected function _update($column)
    {
        $perm = $this->getPermissions();
        $options = $column->getOptions();

        if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {
            $websiteIds = $this->getCoreResource()->getWebsiteIdsByStores($perm->getStoreIds());

            foreach($options as $websiteId => $label) {
                if (!in_array($websiteId, $websiteIds)) {
                    unset($options[$websiteId]);
                }
            }
        }

        $column->setOptions($options);
    }
}
