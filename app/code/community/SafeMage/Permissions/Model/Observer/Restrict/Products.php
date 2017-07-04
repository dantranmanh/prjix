<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Observer_Restrict_Products
    extends SafeMage_Permissions_Model_Observer_Restrict_Abstract
{
    public function getPermissions()
    {
        $perm = $this->getSession()->getPermissions('product');
        return $perm;
    }

    public function getProductsClassHelper()
    {
        return Mage::helper('safemage_permissions/class_products');
    }

    public function onCoreBlockAbstractToHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
    }

    public function onAdminhtmlBlockHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();

        if ($perm = $this->getPermissions()) {
            if ($this->getProductsClassHelper()->isCatalogProductGridContainer($block)) {
                if (!$perm->canCreate()) {
                    $block->removeButton('add_new');
                }
            }
            if ($this->getProductsClassHelper()->isCatalogProductEdit($block)) {
                if (!$perm->canEdit()) {
                    $block->unsetChild('save_button');
                    $block->unsetChild('save_and_edit_button');
                }
                if (!$perm->canDelete()) {
                    $block->unsetChild('delete_button');
                }
            }
            if ($this->getProductsClassHelper()->isCatalogProductGrid($block)) {
                if (!$perm->canEdit()) {
                    $block->getMassactionBlock()->removeItem('status');
                    $block->getMassactionBlock()->removeItem('attributes');
                }
                if (!$perm->canDelete()) {
                    $block->getMassactionBlock()->removeItem('delete');
                }
            }
        }
    }

    public function onCoreBlockAbstractToHtmlAfter(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        $transport = $observer->getTransport();

        if ($this->canRun()) {
            if ($this->getProductsClassHelper()->isCatalogProductEditTabs($block)) {
                $js = Mage::getBlockSingleton('safemage_permissions/Adminhtml_Fix_CatalogProductEditTabsAfter');
                $transport->setHtml($transport->getHtml() . $js->toHtml());
            }
        }
    }
}
