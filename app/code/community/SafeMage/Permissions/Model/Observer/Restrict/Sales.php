<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Observer_Restrict_Sales extends SafeMage_Permissions_Model_Observer_Restrict_Abstract
{
    public function getPermissions()
    {
        $perm = $this->getSession()->getPermissions('sale');
        return $perm;
    }

    public function getSalesRestrictor()
    {
        return Mage::getResourceModel('safemage_permissions/restrict_sales');
    }

    public function getSalesClassHelper()
    {
        return Mage::helper('safemage_permissions/class_sales');
    }

    public function onCoreCollectionAbstractLoadBefore(Varien_Event_Observer $observer)
    {
        $collection = $observer->getCollection();

        if ($perm = $this->getPermissions()) {
            if (count($perm->getStoreIds())) {
                if ($this->getSalesClassHelper()->isOrderGridCollection($collection)) {
                    $this->getSalesRestrictor()->orderGridCollection($collection, $perm);
                } elseif ($this->getSalesClassHelper()->isInvoiceGridCollection($collection)) {
                    $this->getSalesRestrictor()->invoiceGridCollection($collection, $perm);
                } elseif ($this->getSalesClassHelper()->isTransactionCollection($collection)) {
                    $this->getSalesRestrictor()->transactionCollection($collection, $perm);
                } elseif ($this->getSalesClassHelper()->isShipmentGridCollection($collection)) {
                    $this->getSalesRestrictor()->shipmentGridCollection($collection, $perm);
                } elseif ($this->getSalesClassHelper()->isCreditmemoCollection($collection)) {
                    $this->getSalesRestrictor()->creditmemoGridCollection($collection, $perm);
                }
            }
        }
    }
}
