<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Class_Categories extends Mage_Core_Helper_Abstract
{
    public function isCatalogCategoryStoreSwitcher($block)
    {
        if ($block->getParentBlock()
         && ($block instanceof Mage_Adminhtml_Block_Store_Switcher)) {
            if (($block->getParentBlock() instanceof Mage_Adminhtml_Block_Catalog_Category_Tree)
             && ($block->getParentBlock()->getNameInLayout() == 'category.tree')) {
                if ($block->getParentBlock()->getParentBlock()) {
                    if ($block->getParentBlock()->getParentBlock()->getNameInLayout() == 'left') {

                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function isCatalogCategoryTree($block)
    {
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Category_Tree) {
            // without AJAX
            if ($block->getNameInLayout() == 'category.tree') {
                if ($block->getParentBlock()) {
                    if ($block->getParentBlock()->getNameInLayout() == 'left') {

                        return true;
                    }
                }
            }

            // with AJAX
            $uri = Mage::app()->getRequest()->getRequestUri();
            if (stristr($uri, 'catalog_category/categoriesJson')
             || stristr($uri, 'catalog_category/tree')) {
                return true;
            }
        }

        return false;
    }

    public function isCatalogCategoryEdit($block)
    {
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Category_Edit_Form) {
            if ($block->getParentBlock()) {
                if ($block->getParentBlock() instanceof Mage_Adminhtml_Block_Catalog_Category_Edit) {

                    return true;
                }
            }

            return false;
        }
    }

    public function isCatalogCategoryTabs($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Catalog_Category_Tabs);
        return $res;
    }

    public function isCatalogCategoryTabAttributes($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Catalog_Category_Tab_Attributes);
        return $res;
    }

    public function isCatalogCategoryResource($object)
    {
        $res = ($object instanceof Mage_Catalog_Model_Resource_Category)
        || ($object instanceof Mage_Catalog_Model_Resource_Eav_Mysql4_Category);
        return $res;
    }
}