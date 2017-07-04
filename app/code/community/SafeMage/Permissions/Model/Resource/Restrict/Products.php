<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Restrict_Products
    extends SafeMage_Permissions_Model_Resource_Restrict_Abstract
{
    public function getConfigHelper()
    {
        return Mage::helper('safemage_permissions/config');
    }

    public function getCoreResource()
    {
        return Mage::getResourceModel('safemage_permissions/core');
    }

    public function getOwnerResource()
    {
        return Mage::getResourceModel('safemage_permissions/attribute_owner');
    }

    public function catalogProductGridCollection($collection, SafeMage_Permissions_Model_Product $perm)
    {
        if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {
            $websiteIds = $this->getCoreResource()->getWebsiteIdsByStores($perm->getStoreIds());
            $collection->addWebsiteFilter($websiteIds);
        }

        if ($perm->isCategoriesAllowed()) {
            $this->_addCategoryIdsFilter($collection, $perm->getCategoryIds());
        } elseif ($perm->isSelectedAllowed()) {
            $this->_addProductIdsFilter($collection, $perm->getIds());
        } elseif ($perm->isOwnedAllowed() && $this->getConfigHelper()->isOwnerEnabled()) {
            $this->_addOwnedProductIdsFilter($collection);
        }
    }

    protected function _addCategoryIdsFilter($collection, $categoryIds)
    {
        $resource = Mage::getSingleton('core/resource');

        $subSelect = new Zend_Db_Select($resource->getConnection('core_read'));
        $subSelect
            ->from(array('ccp' => $resource->getTableName('catalog/category_product')))
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns('product_id')
            ->where('category_id IN (?)', $categoryIds)
            ->group('product_id')
        ;

        $collection
            ->getSelect()
            ->join(
                array('products_allowed' => new Zend_Db_Expr('(' . $subSelect->assemble() . ')')),
                "products_allowed.product_id = e.entity_id"
            )
        ;
    }

    protected function _addProductIdsFilter($collection, $productIds)
    {
        $collection
            ->addFieldToFilter('entity_id', array('in' => $productIds))
        ;
    }

    protected function _addOwnedProductIdsFilter($collection)
    {
        $user = $this->getSession()->getUser();
        $productIds = $this->getOwnerResource()->getOwnedProductIds($user);

        $collection
            ->addFieldToFilter('entity_id', array('in' => $productIds))
        ;
    }
}