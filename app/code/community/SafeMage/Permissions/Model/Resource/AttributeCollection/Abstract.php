<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/


abstract class SafeMage_Permissions_Model_Resource_AttributeCollection_Abstract
    extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Attribute_Collection
{
    abstract protected function _getEntityTypeId();

    protected function _initSelect()
    {
        $parent = parent::_initSelect();

        $select = $this->getSelect();
        $this->_modifySelect($select);

        return $this;
    }

    public function getRole()
    {
        $role = Mage::registry('current_role');
        return $role;
    }

    protected function _setEntityType(Varien_Db_Select $select)
    {
        if ($entityTypeId = $this->_getEntityTypeId()) {
            $where = $select->getPart(Zend_Db_Select::WHERE);
            if (count($where)) {
                foreach ($where as $i => &$value) {
                    if (stristr($value, 'main_table.entity_type_id')) {
                        $value = "main_table.entity_type_id = {$entityTypeId}";
                    }
                }
            }
            $select->setPart(Zend_Db_Select::WHERE, $where);
        }
    }

    protected function _modifySelect(Varien_Db_Select $select)
    {
        $this->_setEntityType($select);

        $roleId = $this->getRole()->getRoleId();
        $select
            ->joinLeft(
                array('spa' => Mage::getSingleton('core/resource')->getTableName('safemage_permissions/attribute')),
                "(spa.attribute_id = main_table.attribute_id) AND (spa.role_id = {$roleId})",
                array('attribute_permission' => 'spa.permission')
            )
        ;
    }
}
