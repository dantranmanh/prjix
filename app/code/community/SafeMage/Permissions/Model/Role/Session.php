<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Role_Session
{
    protected $_permissions;

    public function getRole()
    {
        if ($user = $this->_getSession()->getUser()) {
            return $user->getRole();
        }

        return null;
    }

    public function getUser()
    {
        return $this->_getSession()->getUser();
    }

    public function getPermissions($type)
    {
        try {
            if (!$this->getRole()) {
                throw new Exception('getRole(): empty');
            }
            if (!$this->getRole()->getRoleId()) {
                throw new Exception('getRoleId(): empty');
            }

            $roleId = $this->getRole()->getRoleId();

            if (isset($this->_permissions[$type])) {
                return $this->_permissions[$type];
            } else {
                $model = Mage::getModel("safemage_permissions/{$type}")->load($roleId, 'role_id');
                if ($model->getRoleId()) {
                    $this->_permissions[$type]= $model;
                    return $model;
                }
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }


        return null;
    }

    protected function _getSession()
    {
        return Mage::getSingleton('admin/session');
    }
}