<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Restrict_Abstract
{
    public function getRequestHelper()
    {
        return Mage::helper('safemage_permissions/request');
    }

    public function getSession()
    {
        return Mage::getSingleton('safemage_permissions/role_session');
    }
}