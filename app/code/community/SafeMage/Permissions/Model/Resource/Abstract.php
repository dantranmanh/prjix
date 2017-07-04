<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

abstract class SafeMage_Permissions_Model_Resource_Abstract extends Mage_Core_Model_Mysql4_Abstract
{
    public function getAttributes($roleId, $entityTypeId)
    {
        try {
            $table = Mage::getSingleton('core/resource')->getTableName('safemage_permissions/attribute');
            $ea = Mage::getSingleton('core/resource')->getTableName('eav/attribute');

            $select = $this->_getReadAdapter()
                ->select()
                ->from(array('attr' => $table))
                ->join(array('ea' => $ea), "ea.attribute_id = attr.attribute_id", array('attribute_code'))
                ->where('attr.role_id = ?', (int)$roleId)
                ->where('attr.entity_type_id = ?', (int)$entityTypeId)
            ;

            $rows = $this->_getReadAdapter()->fetchAll($select);
            return $rows;

        } catch (Exception $e) {
            Mage::logException($e);
        }
    }
}