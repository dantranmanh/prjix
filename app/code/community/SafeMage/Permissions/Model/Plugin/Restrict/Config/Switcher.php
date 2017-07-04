<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Plugin_Restrict_Config_Switcher
    extends SafeMage_Permissions_Model_Plugin_Restrict_Config_Block
{
    /**
     * Detect if this Block should be processed
     *
     * @param Mage_Core_Block_Abstract
     * @return bool
     */
    protected function _detect($object)
    {
        $res = $this->getConfigClassHelper()->isSystemConfigSwitcher($object);
        return $res;
    }

    /**
     * Show only allowed store ids
     *
     * @param Mage_Adminhtml_Block_System_Config_Switcher $object
     * @param array $result
     * @param array $arguments
     * @return array
     */
    public function afterGetStoreSelectOptions($object, $result, array &$arguments)
    {
        if ($this->_detect($object)) {
            if ($perm = $this->getPermissions()) {
                if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {
                    Mage::helper('safemage_permissions/configSwitcher')->update($result, $perm->getStoreIds());
                }
            }
        }

        return $result;
    }
}
