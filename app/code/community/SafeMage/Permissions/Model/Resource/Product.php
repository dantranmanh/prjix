<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Product extends SafeMage_Permissions_Model_Resource_Abstract
{
    protected $_entityTypeId = 4;

    protected function _construct()
    {
        $this->_init('safemage_permissions/product', 'item_id');
    }

    public function filterProductIdsByWebsites($productIds, $websiteIds)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from(Mage::getSingleton('core/resource')->getTableName('catalog/product_website'))
            ->where('product_id IN (?)', $productIds)
            ->where('website_id IN (?)', $websiteIds)
        ;

        $rows = $adapter->fetchAll($select);
        $productIds = array();
        foreach($rows as $row) {
            $productIds[]= (int)$row['product_id'];
        }
        $productIds = array_unique($productIds);

        return $productIds;
    }
}