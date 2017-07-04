<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Core
{
    public function getWebsiteIdsByStores($storeIds)
    {
        $collection = Mage::getResourceModel('core/website_collection')
            ->joinGroupAndStore()
        ;

        if (!Mage::helper('safemage_permissions/request')->getAllStoresSelected($storeIds)) {
            $collection->addFieldToFilter('store_id', array('in' => $storeIds));
        }

        $websiteIds = array();
        foreach($collection as $w) {
            $websiteIds[]= $w->getWebsiteId();
        }

        $websiteIds = array_unique($websiteIds);
        return $websiteIds;
    }

    public function getStoreCodesByIds($storeIds)
    {
        $collection = Mage::getResourceModel('core/store_collection')
            ->addFieldToFilter('store_id', array('in' => $storeIds))
        ;
        $codes = array();
        foreach($collection as $store) {
            $codes[]= $store->getCode();
        }

        return $codes;
    }

    public function getConfigSwitcherStoreCodesByIds($storeIds)
    {
        $codes = $this->getStoreCodesByIds($storeIds);
        foreach($codes as $i => $code) {
            $codes[$i]= 'store_' . $code;
        }

        return $codes;
    }
}