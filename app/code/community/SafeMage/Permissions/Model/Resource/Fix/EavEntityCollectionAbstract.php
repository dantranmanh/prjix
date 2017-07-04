<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Resource_Fix_EavEntityCollectionAbstract
    extends Mage_Eav_Model_Entity_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('catalog/product');
    }

    public function fixGetAttributeTableAlias($attributeCode)
    {
        return parent::_getAttributeTableAlias($attributeCode);
    }
}
