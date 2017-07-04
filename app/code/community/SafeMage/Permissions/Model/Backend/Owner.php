<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Backend_Owner extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    public function validate($object)
    {
        //Mage::throwException('Exception');
    }

    public function beforeSave($object) {

        $attributeCode = $this->getAttribute()->getName();
        $data = $object->getData($attributeCode);

        if (empty($data)) {
            $object->setData($attributeCode, false);
        } else {
            $data = is_array($data) ? $data : array($data);    // CE 1.5 fix
            $object->setData($attributeCode, join(',', $data));
        }

        return $this;
    }

    public function afterLoad($object) {
        return $this;
    }
}
