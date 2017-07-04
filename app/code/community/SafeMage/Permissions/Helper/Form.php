<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Form extends Mage_Core_Helper_Abstract
{
    public function addStoreViewField(Varien_Data_Form_Element_Fieldset $fieldset, $name)
    {
        $field = null;
        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField($name, 'multiselect', array(
                'name'      => $name . '[]',
                'label'     => Mage::helper('safemage_permissions')->__('Store View'),
                'title'     => Mage::helper('safemage_permissions')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
                'disabled'  => false,
            ));
        }
        else {
            $field = $fieldset->addField($name, 'hidden', array(
                'name'      => $name . '[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
        }

        return $field;
    }

    public function addWebsiteField(Varien_Data_Form_Element_Fieldset $fieldset, $name)
    {
        $field = $fieldset->addField($name, 'multiselect', array(
            'name'      => $name . '[]',
            'label'     => Mage::helper('safemage_permissions')->__('Website'),
            'title'     => Mage::helper('safemage_permissions')->__('Website'),
            'required'  => true,
            'values' =>  Mage::getSingleton('adminhtml/system_store')->getWebsiteValuesForForm(false, true),
            'disabled'  => false,
        ))->setSize(5);

        return $field;
    }

    public function setReadonlyElements(Varien_Data_Form_Element_Fieldset $fieldset, SafeMage_Permissions_Model_Abstract $perm)
    {
        $elements = $fieldset->getSortedElements();
        foreach($elements as $element) {
            if ($attribute = $element->getData('entity_attribute')) {
                if ($perm->isAttributeReadonly( $attribute->getAttributeId() )) {
                    $element->setReadonly(true);
                    $element->setDisabled(true);
                }
            }
        }
    }

    public function isConfigSection($field)
    {
        if ($field) {
            $tab = (string)$field->tab;
            $label = (string)$field->label;
            $groups = (array)$field->groups;
            if ($tab && $label && count($groups)) {
                return true;
            }
        }

        return false;
    }

    public function isConfigSectionGroup($field)
    {
        if ($field) {
            $fields = (array)$field->fields;
            if (count($fields)) {
                return true;
            }
        }

        return false;
    }
}