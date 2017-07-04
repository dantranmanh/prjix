<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Sales_GridColumnFilterStore
extends SafeMage_Permissions_Model_Plugin_Restrict_GridColumnFilterStore
{
    /**
     * Sale Permissions of current admin
     *
     * @return SafeMage_Permissions_Model_Sale
     */
    public function getPermissions()
    {
        $perm = $this->getSession()->getPermissions('sale');
        return $perm;
    }

    /**
     * Detect Order Grid
     *
     * @param Mage_Adminhtml_Block_Sales_Order_Grid
     * @return bool
     */
    protected function _detect($object)
    {
        $res = $this->getSalesClassHelper()->isOrderGrid($object);
        return $res;
    }

    /**
     * Detect if this storeId should be displayed in the grid filter dropdown
     *
     * @param int $storeId
     * @return bool
     */
    protected function _canShow($storeId)
    {
        if ($perm = $this->getPermissions()) {
            $res = $perm->isStoreAllowed($storeId);
            return $res;
        }

        return true;
    }
}
