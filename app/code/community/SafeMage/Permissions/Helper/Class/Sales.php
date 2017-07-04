<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Class_Sales extends Mage_Core_Helper_Abstract
{
    public function isOrderGridCollection($collection)
    {
        $res = ($collection instanceof Mage_Sales_Model_Resource_Order_Grid_Collection)
         || ($collection instanceof Mage_Sales_Model_Mysql4_Order_Grid_Collection);

        return $res;
    }

    public function isInvoiceGridCollection($collection)
    {
        $res = ($collection instanceof Mage_Sales_Model_Resource_Order_Invoice_Grid_Collection)
         || ($collection instanceof Mage_Sales_Model_Mysql4_Order_Invoice_Grid_Collection);

        return $res;
    }

    public function isTransactionCollection($collection)
    {
        $res = ($collection instanceof Mage_Sales_Model_Resource_Order_Payment_Transaction_Collection)
         || ($collection instanceof Mage_Sales_Model_Mysql4_Order_Payment_Transaction_Collection);

        return $res;
    }

    public function isShipmentGridCollection($collection)
    {
        $res = ($collection instanceof Mage_Sales_Model_Resource_Order_Shipment_Grid_Collection)
         || ($collection instanceof Mage_Sales_Model_Mysql4_Order_Shipment_Grid_Collection);

        return $res;
    }

    public function isCreditmemoCollection($collection)
    {
        $res = ($collection instanceof Mage_Sales_Model_Resource_Order_Creditmemo_Grid_Collection)
         || ($collection instanceof Mage_Sales_Model_Mysql4_Order_Creditmemo_Grid_Collection);

        return $res;
    }

    public function isOrderGrid($object)
    {
        $res = ($object instanceof Mage_Adminhtml_Block_Sales_Order_Grid);
        return $res;
    }

    public function isInvoiceGrid($object)
    {
        $res = ($object instanceof Mage_Adminhtml_Block_Sales_Invoice_Grid);
        return $res;
    }

    public function isTransactionGrid($object)
    {
        $res = ($object instanceof Mage_Adminhtml_Block_Sales_Transactions_Grid);
        return $res;
    }

    public function isShipmentGrid($object)
    {
        $res = ($object instanceof Mage_Adminhtml_Block_Sales_Shipment_Grid);
        return $res;
    }

    public function isCreditmemoGrid($object)
    {
        $res = ($object instanceof Mage_Adminhtml_Block_Sales_Creditmemo_Grid);
        return $res;
    }
}