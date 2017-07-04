<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Config extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Test');
    }

    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    public function _beforeToHtml() {
        $this->_initForm();

        return parent::_beforeToHtml();
    }

    protected function _initForm()
    {
        $confVarName = Mage::helper('safemage_permissions/request')->getConfigVarName();

        $perm = Mage::registry('current_role')->getPermissions('config');
        $form = new Varien_Data_Form();

        $fsStores = $form->addFieldset('fs-store', array('legend' => Mage::helper('safemage_permissions')->__('Store View')));
        $fsAttributes = $form->addFieldset('fs-conf-sec-permissions', array('legend' => Mage::helper('safemage_permissions')->__('Accessible Sections')));

        $storeViewField = Mage::helper('safemage_permissions/form')->addStoreViewField($fsStores, $confVarName . '[store_ids]');
        if (!Mage::app()->isSingleStoreMode()) {
            $sStoreIds = implode(',', $perm->getStoreIds());
            $storeViewField->setValue($sStoreIds);
        }

        $fsAttributes->addType('custom_field', 'SafeMage_Permissions_Block_Adminhtml_Form_CustomField');
        $attrPermissions = $this->getLayout()->getBlock('config.sectionpermissions');
        $field = $fsAttributes->addField('attribute_permissions', 'custom_field', array(
            'label_block'     => $attrPermissions,
        ));

        //$form->setValues($this->getRole()->getData());
        $this->setForm($form);
    }
}
