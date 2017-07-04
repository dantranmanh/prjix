<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Acl
{
    protected $_rules = array();

    protected function _getReadAdapter()
    {
        return Mage::getResourceSingleton('core/resource')->getReadConnection('core_read');
    }

    public function getRules($roleId)
    {
        if (isset($this->_rules[$roleId])) {
            return $this->_rules[$roleId];
        }

        try {
            $table = Mage::getSingleton('core/resource')->getTableName('admin/rule');

            $select = $this->_getReadAdapter()
                ->select()
                ->from(array('r' => $table))
                ->where('r.role_id = ?', (int)$roleId)
            ;

            $this->_rules[$roleId] = $this->_getReadAdapter()->fetchAll($select);
            return $this->_rules[$roleId];

        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    public function isAllowed($roleId, $resourceId)
    {
        $rules = $this->getRules($roleId);
        foreach($rules as $rule) {
            if (($rule['resource_id'] == $resourceId)
                && ($rule['permission'] == 'allow')) {
                return true;
            }

            if (($rule['resource_id'] == Mage_Admin_Model_Resource_Acl::ACL_ALL_RULES)
                && ($rule['permission'] == 'allow')) {
                return true;
            }
        }
        return false;
    }
}