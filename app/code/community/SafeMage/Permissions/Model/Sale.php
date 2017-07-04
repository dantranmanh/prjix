<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Sale extends SafeMage_Permissions_Model_Abstract
{
    protected $_fieldsToEncode = array('store_ids', 'allow_access_to');

    protected $_fieldsToDecode = array('store_ids', 'allow_access_to');

    const ALLOW_ACCESS_TO_ORDERS                = 1;
    const ALLOW_ACCESS_TO_INVOICES_TRANSACTIONS = 2;
    const ALLOW_ACCESS_TO_SHIPMENTS             = 3;
    const ALLOW_ACCESS_TO_CREDITMEMOS           = 4;

    protected function _construct()
    {
        $this->_init('safemage_permissions/sale');
    }

    public function getTabsAvailable()
    {
        return array();
    }

    public function isOrdersAllowed()
    {
        $isAllowed = in_array(self::ALLOW_ACCESS_TO_ORDERS, $this->getAllowAccessTo());
        return $isAllowed;
    }

    public function isInvoicesTransactionsAllowed()
    {
        $isAllowed = in_array(self::ALLOW_ACCESS_TO_INVOICES_TRANSACTIONS, $this->getAllowAccessTo());
        return $isAllowed;
    }

    public function isShipmentsAllowed()
    {
        $isAllowed = in_array(self::ALLOW_ACCESS_TO_SHIPMENTS, $this->getAllowAccessTo());
        return $isAllowed;
    }

    public function isCreditmemosAllowed()
    {
        $isAllowed = in_array(self::ALLOW_ACCESS_TO_CREDITMEMOS, $this->getAllowAccessTo());
        return $isAllowed;
    }
}