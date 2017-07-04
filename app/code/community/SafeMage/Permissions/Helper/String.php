<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_String extends Mage_Core_Helper_Abstract
{
    public function addOwner($sOwners, $userId)
    {
        $owners = $sOwners ? explode(',', $sOwners) : array();
        if (!in_array($userId, $owners)) {
            $owners[] = $userId;
        }
        $sOwners = implode(',', $owners);
        return $sOwners;
    }

    public function removeOwner($sOwners, $userId)
    {
        $owners = $sOwners ? explode(',', $sOwners) : array();
        $key = array_search($userId, $owners);
        if ($key !== false) {
            unset($owners[$key]);
        }

        $sOwners = count($owners) ? implode(',', $owners) : null;
        return $sOwners;
    }
}