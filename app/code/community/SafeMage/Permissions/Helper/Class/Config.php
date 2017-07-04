<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Class_Config extends Mage_Core_Helper_Abstract
{
    public function isSystemConfigForm($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_System_Config_Form);
        return $res;
    }

    public function isSystemConfigFormFieldset($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_System_Config_Form_Fieldset);
        return $res;
    }

    public function isSystemConfigSwitcher($block)
    {
        $res = ($block instanceof Mage_Adminhtml_Block_System_Config_Switcher);
        return $res;
    }
}