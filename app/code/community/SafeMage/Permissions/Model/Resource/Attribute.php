<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Attribute extends Mage_Core_Model_Mysql4_Abstract
{
    const ATTR_INFO_CACHE_KEY = 'safemage_permissions_attr_info';
    const ATTR_GROUPS_CACHE_KEY = 'safemage_permissions_attr_groups';


    protected function _construct()
    {
        $this->_init('safemage_permissions/attribute', 'item_id');
    }

    public function update($roleId, $attrPermissions, $entityTypeId)
    {
        try {
            $table = Mage::getSingleton('core/resource')->getTableName('safemage_permissions/attribute');

            $this->_getWriteAdapter()->beginTransaction();
            $this->_getWriteAdapter()->delete(
                $table,
                array(
                    'entity_type_id = ?' => (int)$entityTypeId,
                    'role_id = ?' => (int)$roleId,
                )
            );

            $rows = array();
            foreach($attrPermissions as $attrId => $permission) {
                $rows[]= array(
                    'role_id' => $roleId,
                    'attribute_id' => $attrId,
                    'entity_type_id' => $entityTypeId,
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

    public function getGroupId($attrId)
    {
        $a = $this->_loadAttrInfo();

        foreach($a as $item) {
            if ((int)$item['attribute_id'] == $attrId) {
                $ginfo = current($item['attribute_set_info']); // Could contain multiple items
                return (int)$ginfo['group_id'];
            }
        }

        return null;
    }

    protected function _saveAttrInfo($a)
    {
        $json = Zend_Json::encode($a);
        Mage::app()->getCache()->save($json, self::ATTR_INFO_CACHE_KEY);
    }

    protected function _loadAttrInfo()
    {
        if ($json = Mage::app()->getCache()->load(self::ATTR_INFO_CACHE_KEY)) {
            $a = Zend_Json::decode($json);
            return $a;
        }

        $collection = Mage::getResourceModel('eav/entity_attribute_collection')
            ->addSetInfo(true)
        ;
        $a = $collection->toArray(array('attribute_id', 'entity_type_id', 'attribute_code', 'attribute_set_info'));
        $a = $a['items'];
        $this->_saveAttrInfo($a);

        return $a;
    }

    public function getGroup($attrId)
    {
        $groupId = $this->getGroupId($attrId);

        $a = $this->_loadGroups();
        foreach($a as $item) {
            if ((int)$item['attribute_group_id'] == $groupId) {
                return $item;
            }
        }

        return null;
    }

    public function getGroupByCode($attrCode, $entityTypeId)
    {
        if ($attr = $this->getByCode($attrCode, $entityTypeId)) {
            $group = $this->getGroup((int)$attr['attribute_id']);
            return $group;
        }

        return null;
    }

    public function getByCode($attrCode, $entityTypeId)
    {
        $a = $this->_loadAttrInfo();
        foreach($a as $item) {
            if (($item['attribute_code'] == $attrCode) && ((int)$item['entity_type_id'] == $entityTypeId)) {
                return $item;
            }
        }

        return null;
    }

    protected function _saveGroups($a)
    {
        $json = Zend_Json::encode($a);
        Mage::app()->getCache()->save($json, self::ATTR_GROUPS_CACHE_KEY);
    }

    protected function _loadGroups()
    {
        if ($json = Mage::app()->getCache()->load(self::ATTR_GROUPS_CACHE_KEY)) {
            $a = Zend_Json::decode($json);
            return $a;
        }

        $collection = Mage::getResourceModel('eav/entity_attribute_group_collection');
        $a = $collection->toArray();
        $a = $a['items'];
        $this->_saveGroups($a);

        return $a;
    }
}