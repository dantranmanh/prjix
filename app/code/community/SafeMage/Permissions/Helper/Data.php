<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Data extends Mage_Core_Helper_Abstract
{
    const LOG_FILE = 'safemage_permissions.log';

    public function log($msg)
    {
        Mage::log($msg, null, self::LOG_FILE);
    }
}