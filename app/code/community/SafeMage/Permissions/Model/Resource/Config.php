<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Config extends Mage_Core_Model_Mysql4_Abstract
{
    protected $_groups = array();

    protected function _construct()
    {
        $this->_init('safemage_permissions/config', 'item_id');
    }

    public function getGroups($roleId)
    {
        if ($this->_groups) {
            return $this->_groups;
        }

        try {
            $cg = Mage::getSingleton('core/resource')->getTableName('safemage_permissions/config_group');

            $select = $this->_getReadAdapter()
                ->select()
                ->from(array('c' => $this->getMainTable()))
                ->join(array('cg' => $cg), "cg.role_id = c.role_id")
                ->where('c.role_id = ?', (int)$roleId)
            ;

            $rows = $this->_getReadAdapter()->fetchAll($select);
            foreach($rows as $row) {
                $configId = $row['config_id'];
                $row['section_id'] = $this->_getSourceConfigSections()->getSectionIdByConfigIdEncoded($configId);
                $this->_groups[$configId]= $row;
            }
            return $this->_groups;

        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    public function update($roleId, $attrPermissions)
    {
        try {
            $table = Mage::getSingleton('core/resource')->getTableName('safemage_permissions/config_group');

            $this->_getWriteAdapter()->beginTransaction();
            $this->_getWriteAdapter()->delete(
                $table,
                array(
                    'role_id = ?' => (int)$roleId,
                )
            );

            $rows = array();
            foreach($attrPermissions as $attrId => $permission) {
                $rows[]= array(
                    'role_id' => $roleId,
                    'config_id' => $attrId,
                    'permission' => $permission
                );
            }

            $this->_getWriteAdapter()->insertMultiple(
                $table,
                $rows
            );
            $this->_getWriteAdapter()->commit();

        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getWriteAdapter()->rollBack();
        }
    }

    protected function _getSourceConfigSections()
    {
        return Mage::getSingleton('safemage_permissions/Source_AccessibleConfigSections');
    }
}