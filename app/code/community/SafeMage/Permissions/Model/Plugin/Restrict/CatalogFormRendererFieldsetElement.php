<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

abstract class SafeMage_Permissions_Model_Plugin_Restrict_CatalogFormRendererFieldsetElement
    extends SafeMage_Permissions_Model_Plugin_Restrict_Abstract
{
    abstract public function getEntityTypeId();

    /**
     * @param Mage_Adminhtml_Block_Catalog_Form_Renderer_Fieldset_Element $object
     * @param string $result
     * @param array $arguments
     * @return string
     */
    public function afterRender($object, $result, array &$arguments)
    {
        if (isset($arguments[0])) {
            $element = $arguments[0];
            if ($attribute = $element->getData('entity_attribute')) {
                if ($this->isAttributeHidden($attribute)) {
                    return '';
                }
            }
        }

        return $result;
    }

    /**
     * Detect if attribute should be hidden
     *
     * @param Mage_Eav_Model_Entity_Attribute $attribute
     * @return bool
     */
    public function isAttributeHidden($attribute)
    {
        if ($perm = $this->getPermissions()) {
            if ($perm->isAttributeHidden($attribute->getAttributeId())
                && ($attribute->getEntityTypeId() == $this->getEntityTypeId())) {

                return true;
            }
        }

        return false;
    }
}
