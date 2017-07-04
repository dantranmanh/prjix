<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Customers_CustomerGridColumnWebsite
extends SafeMage_Permissions_Model_Plugin_Restrict_GridColumn
{
    /**
     * Customer Permissions of current admin
     *
     * @return SafeMage_Permissions_Model_Customer
     */
    public function getPermissions()
    {
        $perm = $this->getSession()->getPermissions('customer');
        return $perm;
    }

    /**
     * Detect if this Grid should be processed
     *
     * @param Mage_Adminhtml_Block_Customer_Grid
     * @return bool
     */
    protected function _detect($object)
    {
        $res = $this->getCustomersClassHelper()->isCustomerManageGrid($object);
        return $res;
    }

    /**
     * Detect if this Grid Column should be processed
     *
     * @param int $columnId
     * @return bool
     */
    protected function _detectId($columnId)
    {
        $res = ($columnId == 'website_id') ? true : false;
        return $res;
    }

    /**
     * Modify Grid Column
     *
     * @param array $column
     */
    protected function _update($column)
    {
        $perm = $this->getPermissions();

        $options = $column->getOptions();
        foreach($options as $websiteId => $label) {
            if (!in_array($websiteId, $perm->getWebsiteIds())) {
                unset($options[$websiteId]);
            }
        }

        $column->setOptions($options);
    }
}
