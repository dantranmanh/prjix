<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Class_Products extends Mage_Core_Helper_Abstract
{
    public function isCatalogProductGridStoreSwitcher($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Catalog_Product)
         || ($block->getParentBlock()->getNameInLayout() == 'products_list');

        return $res;
    }

    public function isCatalogProductEditStoreSwitcher($block)
    {
        if ($block->getParentBlock()) {
            $tabs = $block->getParentBlock()->getChild('product_tabs');
            if ($tabs instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs) {
                return true;
            }
        }

        return false;
    }

    public function isOrderCreateStoreSwitcher($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Sales_Order_Create_Store_Select);
        return $res;
    }

    public function isCatalogProductGridContainer($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Catalog_Product);
        return $res;
    }

    public function isCatalogProductEdit($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit);
        return $res;
    }

    public function isCatalogProductGrid($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Grid);
        return $res;
    }

    public function isCatalogProductEditTabAttributes($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Attributes);
        return $res;
    }

    public function isCatalogProductEditTabs($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs);
        return $res;
    }
}