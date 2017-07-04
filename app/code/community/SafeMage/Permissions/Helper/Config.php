<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_Config extends Mage_Core_Helper_Abstract
{
    const PATH_IS_OWNER_ENABLED = 'safemage_permissions/general/owner_enabled';

    const FILTER_SELECTED_DATA_BY_STORES_ENABLED = true;

    public function isOwnerEnabled($store = null)
    {
        return Mage::getStoreConfigFlag(self::PATH_IS_OWNER_ENABLED, $store);
    }

    public function getFilterSelectedDataByStoresEnabled()
    {
        return self::FILTER_SELECTED_DATA_BY_STORES_ENABLED;
    }

    public function isSystemConfigSectionAllowed($sectionId)
    {
        /*
        $resourceId = "admin/system/config/{$sectionId}";
        $allowed = Mage::getSingleton('admin/session')->isAllowed($resourceId);
        return $allowed;
        */

        if ($role = Mage::registry('current_role')) {
            $resourceId = "admin/system/config/{$sectionId}";
            $allowed = $this->_getAcl()->isAllowed($role->getRoleId(), $resourceId);
            return $allowed;
        }

        return true;
    }

    protected function _getAcl()
    {
        return Mage::getResourceSingleton('safemage_permissions/acl');
    }
}