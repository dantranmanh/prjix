<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Observer_Block
{
    public function onCoreBlockAbstractToHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        if ($this->_isUserSaveButton($block)) {
            $jsAdd = "if (typeof(window.safemageSetHiddenSelectedProducts) != 'undefined') { window.safemageSetHiddenSelectedProducts(); } ";

            $onClick = $block->getData('onclick');
            $onClick = $jsAdd . $onClick;
            $block->setData('onclick', $onClick);
        }

        if ($this->_isRoleSaveButton($block)) {
            $jsAdd = "if (typeof(window.safemageSetHiddenSelectedProducts) != 'undefined') { window.safemageSetHiddenSelectedProducts(); } ";

            $onClick = $block->getData('onclick');
            $onClick = $jsAdd . $onClick;
            $block->setData('onclick', $onClick);
        }

        if ($block instanceof Mage_Adminhtml_Block_Permissions_User_Edit_Tabs) {

            if (Mage::helper('safemage_permissions/config')->isOwnerEnabled()) {
                $attribute = Mage::getResourceModel('safemage_permissions/attribute_owner')->get();

                if ($attribute->getIsVisible()) {
                    $block->addTab('own_products', array(
                        'label' => Mage::helper('safemage_permissions')->__('Advanced: Owned Products'),
                        'url'   => $block->getUrl('adminhtml/safemage_permissions_ajax/getUserOwnProducts', array('_current' => true)),
                        'class' => 'ajax',
                        'after' => 'roles_section',
                    ));
                }
            }
        }

        if ($block instanceof Mage_Adminhtml_Block_Permissions_Editroles) {
            if (Mage::registry('current_role')->getRoleId()) {

                $block->addTab('categories', array(
                    'label' => Mage::helper('safemage_permissions')->__('Advanced: Categories'),
                    'url' => $block->getUrl('adminhtml/safemage_permissions_ajax/getRoleCategories', array('_current' => true)),
                    'class' => 'ajax',
                ));

                $block->addTab('products', array(
                    'label' => Mage::helper('safemage_permissions')->__('Advanced: Products'),
                    'url' => $block->getUrl('adminhtml/safemage_permissions_ajax/getRoleProducts', array('_current' => true)),
                    'class' => 'ajax',
                ));

                $block->addTab('sales', array(
                    'label' => Mage::helper('safemage_permissions')->__('Advanced: Sales'),
                    'url' => $block->getUrl('adminhtml/safemage_permissions_ajax/getRoleSales', array('_current' => true)),
                    'class' => 'ajax',
                ));

                $block->addTab('customers', array(
                    'label' => Mage::helper('safemage_permissions')->__('Advanced: Customers'),
                    'url' => $block->getUrl('adminhtml/safemage_permissions_ajax/getRoleCustomers', array('_current' => true)),
                    'class' => 'ajax',
                ));

                $block->addTab('config', array(
                    'label' => Mage::helper('safemage_permissions')->__('Advanced: Configuration'),
                    'url' => $block->getUrl('adminhtml/safemage_permissions_ajax/getRoleConfig', array('_current' => true)),
                    'class' => 'ajax',
                ));
            }
        }
    }

    public function onCoreBlockAbstractToHtmlAfter(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        $transport = $observer->getTransport();

        // For debug purposes
    }

    public function onCoreBlockAbstractPrepareLayoutBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
    }

    protected function _isUserSaveButton($block)
    {
        if ($block instanceof Mage_Adminhtml_Block_Widget_Button) {
            if (($block->getLabel() == 'Save User')
                && ($block->getParentBlock() instanceof Mage_Adminhtml_Block_Permissions_User_Edit)) {
                return true;
            }
        }
        return false;
    }

    protected function _isRoleSaveButton($block)
    {
        if ($block instanceof Mage_Adminhtml_Block_Widget_Button) {
            if (($block->getLabel() == 'Save Role')
                && ($block->getParentBlock() instanceof Mage_Adminhtml_Block_Permissions_Buttons)) {
                return true;
            }
        }
        return false;
    }
}
