<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Tree
{
    public function addStoreFilter(Varien_Data_Tree_Node_Collection $collection, $storeIds)
    {
        $rootCategoryIds = $this->getRootCategoryIdsByStores($storeIds);
        foreach($collection as $child) {
            if (!in_array($child->getEntityId(), $rootCategoryIds)) {
                $collection->delete($child);
            }
        }
    }

    public function getRootCategoryIdsByStores($storeIds)
    {
        $collection = Mage::getResourceModel('core/store_collection')
            ->addRootCategoryIdAttribute()
            ->addIdFilter($storeIds)
        ;
        $rootCategoryIds = array();
        foreach($collection as $s) {
            $rootCategoryIds[]= (int)$s->getData('root_category_id');
        }

        $rootCategoryIds = array_unique($rootCategoryIds);
        return $rootCategoryIds;
    }

    public function filterCategoryIdsByStores($categoryIds, $storeIds)
    {
        $allowedRootCategoryIds = $this->getRootCategoryIdsByStores($storeIds);
        $aLike = array();
        foreach($allowedRootCategoryIds as $rootCatId) {
            $aLike[]= array('like' => "1/{$rootCatId}");
            $aLike[]= array('like' => "1/{$rootCatId}/%");
        }

        $collection = Mage::getResourceModel('catalog/category_collection')
            ->addFieldToFilter('entity_id', array('in' => $categoryIds))
        ;
        if (count($aLike) && (!Mage::helper('safemage_permissions/request')->getAllStoresSelected($storeIds))) {
            $collection->addFieldToFilter('path', $aLike);
        }

        $catIds = array();
        foreach($collection as $cat) {
            $catIds[]= $cat->getEntityId();
        }

        return $catIds;
    }
}