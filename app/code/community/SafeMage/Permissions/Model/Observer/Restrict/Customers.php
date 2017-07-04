<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Observer_Restrict_Customers
    extends SafeMage_Permissions_Model_Observer_Restrict_Abstract
{
    public function getPermissions()
    {
        $perm = $this->getSession()->getPermissions('customer');
        return $perm;
    }

    public function getCustomersRestrictor()
    {
        return Mage::getResourceModel('safemage_permissions/restrict_customers');
    }

    public function getCustomersClassHelper()
    {
        return Mage::helper('safemage_permissions/class_customers');
    }

    public function getCustomerTabsPlugin()
    {
        return Mage::getModel('safemage_permissions/Plugin_Restrict_Customers_CustomerTabs');
    }

    public function onEavCollectionAbstractLoadBefore(Varien_Event_Observer $observer)
    {
        $collection = $observer->getCollection();

        if ($perm = $this->getPermissions()) {
            if (count($perm->getWebsiteIds())) {
                if ($this->getCustomersClassHelper()->isCustomerManageCollection($collection)) {
                    $this->getCustomersRestrictor()->customerManageCollection($collection, $perm);
                }
            }
        }
    }

    public function onAdminhtmlBlockHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();

        if ($perm = $this->getPermissions()) {

            if ($this->getCustomersClassHelper()->isCustomerTabs($block)) {
                $this->getCustomerTabsPlugin()->correctActiveTab($block);
            }

            if ($this->getCustomersClassHelper()->isCustomerManageGridContainer($block)) {
                if (!$perm->canCreate()) {
                    $block->removeButton('add');
                }
            }

            if ($this->getCustomersClassHelper()->isCustomerEdit($block)) {
                if (!$perm->canEdit()) {
                    $block->removeButton('save');
                    $block->removeButton('save_and_continue');
                }
                if (!$perm->canDelete()) {
                    $block->removeButton('delete');
                }
            }

            if ($this->getCustomersClassHelper()->isCustomerManageGrid($block)) {
                if (!$perm->canEdit()) {
                    $block->getMassactionBlock()->removeItem('newsletter_subscribe');
                    $block->getMassactionBlock()->removeItem('newsletter_unsubscribe');
                    $block->getMassactionBlock()->removeItem('assign_group');
                }
                if (!$perm->canDelete()) {
                    $block->getMassactionBlock()->removeItem('delete');
                }
            }
        }
    }
}
