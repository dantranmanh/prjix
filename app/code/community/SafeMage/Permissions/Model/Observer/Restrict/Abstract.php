<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

abstract class SafeMage_Permissions_Model_Observer_Restrict_Abstract
{
    abstract public function getPermissions();

    public function canRun()
    {
        $perm = $this->getPermissions();
        return (bool)$perm;
    }

    public function getSession()
    {
        return Mage::getSingleton('safemage_permissions/role_session');
    }

    /**
     * @return SafeMage_Permissions_Helper_Request
     */
    public function getRequestHelper()
    {
        return Mage::helper('safemage_permissions/request');
    }
}
