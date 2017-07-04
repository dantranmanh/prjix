<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Role extends Mage_Admin_Model_Role
{
    public function getPermissions($type)
    {
        $model = Mage::getModel("safemage_permissions/{$type}")->load($this->getRoleId(), 'role_id');
        if (!$model->getRoleId()) {
            $model->setRoleId($this->getRoleId());
        }

        return $model;
    }

    public function setPermissions($type, $data)
    {
        $perm = $this->getPermissions($type);
        $perm
            ->addData($data)
            ->save()
        ;
        return $this;
    }
}