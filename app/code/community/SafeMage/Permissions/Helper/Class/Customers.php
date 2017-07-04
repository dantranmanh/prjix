<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Class_Customers extends Mage_Core_Helper_Abstract
{
    public function isCustomerManageGrid($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Customer_Grid);
        return $res;
    }

    public function isCustomerManageGridContainer($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Customer);
        return $res;
    }

    public function isCustomerEdit($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_Customer_Edit);
        return $res;
    }

    public function isCustomerManageCollection($object)
    {
        $res = ($object instanceof Mage_Customer_Model_Resource_Customer_Collection)
        || ($object instanceof Mage_Customer_Model_Entity_Customer_Collection);

        return $res;
    }

    public function isCustomerTabs($object)
    {
        $res = ($object instanceof Mage_Adminhtml_Block_Customer_Edit_Tabs);
        return $res;
    }

    public function isCustomerEditTabAccount($object)
    {
        $res = ($object instanceof Mage_Adminhtml_Block_Customer_Edit_Tab_Account);
        return $res;
    }
}