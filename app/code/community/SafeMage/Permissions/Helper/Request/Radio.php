<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Request_Radio extends Mage_Core_Helper_Abstract
{
    const DELIMITER_1 = '|';
    const DELIMITER_2 = ',';

    protected $_permissions;

    public function encode(array $permissions)
    {
        $values = array();
        foreach($permissions as $attrId => $permission) {
            $values[]= $attrId . self::DELIMITER_1 . $permission;
        }
        $gluedValues = implode(self::DELIMITER_2, $values);
        return $gluedValues;
    }

    public function decode($gluedValues)
    {
        $values = explode(self::DELIMITER_2, $gluedValues);
        $permissions = array();
        foreach($values as $value) {
            $parts = explode(self::DELIMITER_1, $value);
            $attrId = $parts[0];  // (int)
            $permission = (int)$parts[1];

            $permissions[$attrId]= $permission;
        }
        return $permissions;
    }

    public function updateStringByArray($gluedValues, $aNew)
    {
        $permissions = $this->decode($gluedValues);

        foreach($aNew as $attrId => $permission) {
            $attrId = (int)$attrId;
            $permission = (int)$permission;

            if (isset($permissions[$attrId])) {
                $permissions[$attrId]= $permission;
            }
        }

        $gluedValues = $this->encode($permissions);
        return $gluedValues;
    }

    public function getAttrPermissionsFromHiddenFilter($gluedValues)
    {
        if (!$this->_permissions) {
            $this->_permissions = $this->decode($gluedValues);
        }

        return $this->_permissions;
    }

    public function getAttrPermission($gluedValues, $attributeId)
    {
        $attributes = $this->getAttrPermissionsFromHiddenFilter($gluedValues);
        $permission = isset($attributes[$attributeId]) ? $attributes[$attributeId] : null;
        return $permission;
    }

    public function getAttrWithPermission($gluedValues, $eqPermission)
    {
        $attributes = $this->getAttrPermissionsFromHiddenFilter($gluedValues);

        $attrIds = array();
        foreach($attributes as $attrId => $permission) {
            if ($permission == $eqPermission) {
                $attrIds[]= $attrId;
            }
        }
        return $attrIds;
    }
}