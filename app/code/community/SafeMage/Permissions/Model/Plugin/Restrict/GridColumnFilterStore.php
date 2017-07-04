<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

abstract class SafeMage_Permissions_Model_Plugin_Restrict_GridColumnFilterStore
extends SafeMage_Permissions_Model_Plugin_Restrict_Block
{
    abstract protected function _canShow($storeId);

    /**
     * Render HTML of the element
     *
     * @return string
     */
    public function aroundGetHtml($object, array $arguments)
    {
        $storeModel = Mage::getSingleton('adminhtml/system_store');
        /* @var $storeModel Mage_Adminhtml_Model_System_Store */
        $websiteCollection = $storeModel->getWebsiteCollection();
        $groupCollection = $storeModel->getGroupCollection();
        $storeCollection = $storeModel->getStoreCollection();

        $allShow = $object->getColumn()->getStoreAll();

        $html  = '<select name="' . $object->escapeHtml($object->getColumn()->getId()) . '" '
               . $object->getColumn()->getValidateClass() . '>';
        $value = $object->getColumn()->getValue();
        if ($allShow) {
            $html .= '<option value="0"' . ($value == 0 ? ' selected="selected"' : '') . '>'
                  . Mage::helper('adminhtml')->__('All Store Views') . '</option>';
        } else {
            $html .= '<option value=""' . (!$value ? ' selected="selected"' : '') . '></option>';
        }
        foreach ($websiteCollection as $website) {
            $websiteShow = false;
            foreach ($groupCollection as $group) {
                if ($group->getWebsiteId() != $website->getId()) {
                    continue;
                }
                $groupShow = false;
                foreach ($storeCollection as $store) {
                    if ($store->getGroupId() != $group->getId()) {
                        continue;
                    }


                    if ($this->_detect($object->getColumn()->getGrid())) {
                        if (!$this->_canShow($store->getId())) {
                            continue;
                        }
                    }

					
                    if (!$websiteShow) {
                        $websiteShow = true;
                        $html .= '<optgroup label="' . $object->escapeHtml($website->getName()) . '"></optgroup>';
                    }
                    if (!$groupShow) {
                        $groupShow = true;
                        $html .= '<optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;'
                              . $object->escapeHtml($group->getName()) . '">';
                    }
                    $value = $object->getValue();
                    $selected = $value == $store->getId() ? ' selected="selected"' : '';
                    $html .= '<option value="' . $store->getId() . '"' . $selected . '>&nbsp;&nbsp;&nbsp;&nbsp;'
                          . $object->escapeHtml($store->getName() ) . '</option>';
                }
                if ($groupShow) {
                    $html .= '</optgroup>';
                }
            }
        }
        if ($object->getColumn()->getDisplayDeleted()) {
            $selected = ($object->getValue() == '_deleted_') ? ' selected' : '';
            $html.= '<option value="_deleted_"'.$selected.'>'.$object->__('[ deleted ]').'</option>';
        }
        $html .= '</select>';
        return $html;
    }
}
