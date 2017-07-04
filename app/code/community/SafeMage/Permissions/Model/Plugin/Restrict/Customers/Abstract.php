<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Customers_Abstract
    extends SafeMage_Permissions_Model_Plugin_Restrict_Abstract
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
}
