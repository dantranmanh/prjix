<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Customer extends SafeMage_Permissions_Model_Resource_Abstract
{
    protected $_entityTypeId = 1;

    protected function _construct()
    {
        $this->_init('safemage_permissions/customer', 'item_id');
    }
}