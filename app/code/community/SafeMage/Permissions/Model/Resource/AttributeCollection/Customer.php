<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/


class SafeMage_Permissions_Model_Resource_AttributeCollection_Customer
    extends SafeMage_Permissions_Model_Resource_AttributeCollection_Abstract
{
    protected function _getEntityTypeId()
    {
        return 1;
    }

    protected function _modifySelect(Varien_Db_Select $select)
    {
        parent::_modifySelect($select);

        // Add attribute_id to COLUMNS
        $columns = $select->getPart(Zend_Db_Select::COLUMNS);
        $columns[]= array('main_table', 'attribute_id', 'attribute_id');
        $select->setPart(Zend_Db_Select::COLUMNS, $columns);

        // Remove additional_table
        $part = $select->getPart(Zend_Db_Select::COLUMNS);
        foreach($part as $key => $a) {
            if ($a[0] == 'additional_table') {
                unset($part[$key]);
            }
        }
        $select->setPart(Zend_Db_Select::COLUMNS, $part);

        $part = $select->getPart(Zend_Db_Select::FROM);
        unset($part['additional_table']);
        $select->setPart(Zend_Db_Select::FROM, $part);
    }
}
