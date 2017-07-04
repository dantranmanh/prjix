<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Restrict_Sales extends SafeMage_Permissions_Model_Resource_Restrict_Abstract
{
    public function getOwnerResource()
    {
        return Mage::getResourceModel('safemage_permissions/attribute_owner');
    }

    public function orderGridCollection($collection, SafeMage_Permissions_Model_Sale $perm)
    {
        if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {
            $collection->getSelect()->where('main_table.store_id IN (?)', $perm->getStoreIds());
        }
        if (!$perm->isOrdersAllowed()) {
            $collection->getSelect()->where('main_table.store_id = 999');
            return;
        }

        if ($perm->getAllowOwnProductsOnly()) {
            $this->getOwnerResource()->filterOwnedSalesData($this->getSession()->getUser(), $collection);
        }
    }

    public function invoiceGridCollection($collection, SafeMage_Permissions_Model_Sale $perm)
    {
        if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {
            $collection->getSelect()->where('main_table.store_id IN (?)', $perm->getStoreIds());
        }
        if (!$perm->isInvoicesTransactionsAllowed()) {
            $collection->getSelect()->where('main_table.store_id = 999');
            return;
        }

        if ($perm->getAllowOwnProductsOnly()) {
            $this->getOwnerResource()->filterOwnedSalesData($this->getSession()->getUser(), $collection);
        }
    }

    public function transactionCollection($collection, SafeMage_Permissions_Model_Sale $perm)
    {
        $select = $collection->getSelect()
          ->join(
              array('sog' => Mage::getSingleton('core/resource')->getTableName('sales/order_grid')),
              "main_table.order_id = sog.entity_id",
              array()
          );
        if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {
            $select->where('sog.store_id IN (?)', $perm->getStoreIds());
        }
        if (!$perm->isInvoicesTransactionsAllowed()) {
            $select->where('sog.store_id = 999');
            return;
        }

        if ($perm->getAllowOwnProductsOnly()) {
            $this->getOwnerResource()->filterOwnedSalesData($this->getSession()->getUser(), $collection);
        }
    }

    public function shipmentGridCollection($collection, SafeMage_Permissions_Model_Sale $perm)
    {
        if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {
            $collection->getSelect()->where('main_table.store_id IN (?)', $perm->getStoreIds());
        }
        if (!$perm->isShipmentsAllowed()) {
            $collection->getSelect()->where('main_table.store_id = 999');
            return;
        }

        if ($perm->getAllowOwnProductsOnly()) {
            $this->getOwnerResource()->filterOwnedSalesData($this->getSession()->getUser(), $collection);
        }
    }

    public function creditmemoGridCollection($collection, SafeMage_Permissions_Model_Sale $perm)
    {
        if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {
            $collection->getSelect()->where('main_table.store_id IN (?)', $perm->getStoreIds());
        }
        if (!$perm->isCreditmemosAllowed()) {
            $collection->getSelect()->where('main_table.store_id = 999');
            return;
        }

        if ($perm->getAllowOwnProductsOnly()) {
            $this->getOwnerResource()->filterOwnedSalesData($this->getSession()->getUser(), $collection);
        }
    }
}