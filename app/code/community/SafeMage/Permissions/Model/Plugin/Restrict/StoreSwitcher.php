<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

abstract class SafeMage_Permissions_Model_Plugin_Restrict_StoreSwitcher
    extends SafeMage_Permissions_Model_Plugin_Restrict_Block
{
    /**
     * Select only choosed store ids
     *
     * @param Mage_Adminhtml_Block_Store_Switcher $object
     * @param array $result
     * @param array $arguments
     * @return array
     */
    public function afterGetStoreIds($object, $result, array &$arguments)
    {
        if ($this->_detect($object)) {
            if ($perm = $this->getPermissions()) {
                if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {

                    return $perm->getStoreIds();
                }
            }
        }

        return $result;
    }

    /**
     * Hide default option if 'All Stores' option is not selected in request
     *
     * @param Mage_Adminhtml_Block_Store_Switcher $object
     * @param bool $result
     * @param array $arguments
     * @return bool
     */
    public function afterHasDefaultOption($object, $result, array &$arguments)
    {
        if ($this->_detect($object)) {
            if ($perm = $this->getPermissions()) {
                if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {

                    return false;
                }
            }
        }

        return $result;
    }

    /**
     * Redirect to allowed Store
     *
     * @param Mage_Adminhtml_Block_Store_Switcher $object
     * @param array $arguments
     */
    public function beforeToHtml($object, array &$arguments)
    {
        if ($this->_detect($object)) {
            if ($perm = $this->getPermissions()) {
                if (!$this->getRequestHelper()->getAllStoresSelected($perm->getStoreIds())) {

                    $storeId = current($perm->getStoreIds());
                    if (!Mage::app()->getRequest()->getParam('store')) {
                        $url = Mage::getModel('adminhtml/url');
                        Mage::app()->getResponse()->setRedirect($url->getUrl('*/*/*', array('_current' => true, 'store' => $storeId)));
                    }
                }
            }
        }
    }
}
