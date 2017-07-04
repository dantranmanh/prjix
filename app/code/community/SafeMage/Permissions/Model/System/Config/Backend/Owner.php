<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_System_Config_Backend_Owner extends Mage_Core_Model_Config_Data
{
    protected function _afterSave()
    {
        parent::_afterSave();
        if ($this->isValueChanged()) {
            $ownerAttribute = Mage::getResourceModel('safemage_permissions/attribute_owner');

            if ( $this->getValue() == 1 ) {
                $ownerAttribute->add();
            } else {
                $ownerAttribute->hide();
            }
        }
        return $this;
    }
}
