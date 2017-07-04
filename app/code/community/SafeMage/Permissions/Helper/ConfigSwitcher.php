<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Helper_ConfigSwitcher extends Mage_Core_Helper_Abstract
{
    public function update(&$options, $storeIds)
    {
        $codes = Mage::getResourceSingleton('safemage_permissions/core')
            ->getConfigSwitcherStoreCodesByIds($storeIds)
        ;

        foreach($options as $code => $data) {
            if ($this->_isStoreViewCode($code)) {
                if (!in_array($code, $codes)) {
                    unset($options[$code]);
                }
            }
        }
    }

    protected function _isStoreViewCode($code)
    {
        $res = (substr($code, 0, 6) == 'store_');
        return $res;
    }
}