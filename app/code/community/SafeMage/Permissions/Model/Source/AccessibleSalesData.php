<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Source_AccessibleSalesData
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => SafeMage_Permissions_Model_Sale::ALLOW_ACCESS_TO_ORDERS,
                'label' => Mage::helper('safemage_permissions')->__('Orders')
            ),
            array(
                'value' => SafeMage_Permissions_Model_Sale::ALLOW_ACCESS_TO_INVOICES_TRANSACTIONS,
                'label' => Mage::helper('safemage_permissions')->__('Invoices and Transactions')
            ),
            array(
                'value' => SafeMage_Permissions_Model_Sale::ALLOW_ACCESS_TO_SHIPMENTS,
                'label' => Mage::helper('safemage_permissions')->__('Shipments')
            ),
            array(
                'value' => SafeMage_Permissions_Model_Sale::ALLOW_ACCESS_TO_CREDITMEMOS,
                'label' => Mage::helper('safemage_permissions')->__('Creditmemos')
            ),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            0 => Mage::helper('safemage_permissions')->__('No'),
            1 => Mage::helper('safemage_permissions')->__('Yes'),
        );
    }
}
