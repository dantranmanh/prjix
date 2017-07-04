<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Attribute extends Mage_Core_Model_Abstract
{
    const PERMISSION_EDITABLE = 1;
    const PERMISSION_READONLY = 2;
    const PERMISSION_HIDDEN   = 3;

    protected function _construct()
    {
        $this->_init('safemage_permissions/attribute');
    }
}