<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Config_SystemConfigFormFieldset
    extends SafeMage_Permissions_Model_Plugin_Restrict_Config_Abstract
{
    /**
     * Hide group
     *
     * @param Mage_Adminhtml_Block_System_Config_Form_Fieldset $object
     * @param bool
     * @param array $arguments
     */
    public function afterGetFooterHtml($object, $result, array &$arguments)
    {
        $perm = $this->getPermissions();
        if ($perm && $this->_detect($object)) {
            $element = $arguments[0];
            $configId = $element->getHtmlId();

            if ($perm->isConfigReadonly($this->_getSourceConfigSections()->encodeConfigId($configId))) {
                $js = Mage::getBlockSingleton('core/template')
                    ->setFieldsetId($configId)
                    ->setTemplate('safemage/permissions/form/config/fieldset_js.phtml')
                    ->toHtml()
                ;
                $result .= $js;
            }
        }

        return $result;
    }

    /**
     * Detect if this Block should be processed
     *
     * @param Mage_Adminhtml_Block_System_Config_Form_Fieldset $object
     * @return bool
     */
    protected function _detect($object)
    {
        $res = $this->getConfigClassHelper()->isSystemConfigFormFieldset($object);
        return $res;
    }
}
