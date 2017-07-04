<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Config_SystemConfigForm
    extends SafeMage_Permissions_Model_Plugin_Restrict_Config_Abstract
{
    /**
     * Hide group
     *
     * @param Mage_Adminhtml_Block_System_Config_Form $object
     * @param bool
     * @param array $arguments
     */
    public function afterCanShowField($object, $result, array &$arguments)
    {
        $perm = $this->getPermissions();
        if ($perm && $this->_detect($object)) {
            $field = $arguments[0];
            if ($this->getFormHelper()->isConfigSectionGroup($field)) {
                $secLabel = (string)$field->getParent()->getParent()->label;
                $gLabel = (string)$field->label;
                $configId = $this->_getSourceConfigSections()
                    ->getConfigId($secLabel, $gLabel)
                ;
                if ($configId) {
                    if ($perm->isConfigHidden($this->_getSourceConfigSections()->encodeConfigId($configId))) {
                        return false;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Detect if this Block should be processed
     *
     * @param Mage_Adminhtml_Block_System_Config_Form $object
     * @return bool
     */
    protected function _detect($object)
    {
        $res = $this->getConfigClassHelper()->isSystemConfigForm($object);
        return $res;
    }
}
