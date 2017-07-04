<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Entity_Type extends Mage_Core_Helper_Abstract
{
    const TYPE_CUSTOMER = 1;
    const TYPE_CATEGORY = 3;
    const TYPE_PRODUCT  = 4;

    public function getCustomer()
    {
        return self::TYPE_CUSTOMER;
    }

    public function getCategory()
    {
        return self::TYPE_CATEGORY;
    }

    public function getProduct()
    {
        return self::TYPE_PRODUCT;
    }
}