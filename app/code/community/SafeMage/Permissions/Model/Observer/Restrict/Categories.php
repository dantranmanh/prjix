<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Observer_Restrict_Categories
    extends SafeMage_Permissions_Model_Observer_Restrict_Abstract
{
    public function getPermissions()
    {
        $perm = $this->getSession()->getPermissions('category');
        return $perm;
    }

    public function getCategoriesClassHelper()
    {
        return Mage::helper('safemage_permissions/class_categories');
    }

    public function getCatalogCategoryTabsPlugin()
    {
        return Mage::getModel('safemage_permissions/Plugin_Restrict_Categories_CatalogCategoryTabs');
    }

    public function onAdminhtmlBlockHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();

        if ($this->canRun()) {

            if ($this->getCategoriesClassHelper()->isCatalogCategoryTabs($block)) {
                $this->getCatalogCategoryTabsPlugin()->correctActiveTab($block);
            }

            $perm = $this->getPermissions();

            if ($this->getCategoriesClassHelper()->isCatalogCategoryEdit($block)) {
                if (!$perm->canEdit()) {
                    $block->unsetChild('save_button');
                }
                if (!$perm->canDelete()) {
                    $block->unsetChild('delete_button');
                }
            }
        }
    }

    public function onCoreBlockAbstractToHtmlAfter(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        $transport = $observer->getTransport();

        if ($this->canRun()) {
            $perm = $this->getPermissions();

            if ($this->getCategoriesClassHelper()->isCatalogCategoryTabs($block)) {
                $js = Mage::getBlockSingleton('safemage_permissions/Adminhtml_Fix_CatalogCategoryEdit');
                $html = $transport->getHtml();
                $transport->setHtml($js->toHtml() . $html);
            }

            if ($this->getCategoriesClassHelper()->isCatalogCategoryTree($block)) {
                if (!$perm->canCreate()) {
                    $html = $transport->getHtml();
                    $css = Mage::getBlockSingleton('safemage_permissions/Adminhtml_Fix_CatalogCategoryTreeBefore');
                    $transport->setHtml($css->toHtml() . $html);
                }
            }

            if ($this->getCategoriesClassHelper()->isCatalogCategoryStoreSwitcher($block)) {
                if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {
                    $html = $transport->getHtml();
                    $html = preg_replace('/<option value="">([^<\/]+)<\/option>/', '', $html);
                    $transport->setHtml($html);
                }
            }
        }
    }
}
