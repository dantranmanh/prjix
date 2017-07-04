<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Sales extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Products');
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
        $perm = Mage::registry('current_role')->getPermissions('sale');
        $form = new Varien_Data_Form();

        $fsStores = $form->addFieldset('fs-store', array('legend'=>Mage::helper('adminhtml')->__('Store View')));
        $fsSales = $form->addFieldset('fs-sales-sales', array('legend'=>Mage::helper('adminhtml')->__('Accessible Sales Data')));

        $storeViewField = Mage::helper('safemage_permissions/form')->addStoreViewField($fsStores, 'sales[store_ids]');
        if (!Mage::app()->isSingleStoreMode()) {
            $sStoreIds = implode(',', $perm->getStoreIds());
            $storeViewField->setValue($sStoreIds);
        }

        $fsSales->addField('sales[allow_access_to]', 'multiselect', array(
            'name'      => 'sales[allow_access_to][]',
            'label'     => Mage::helper('safemage_permissions')->__('Allow Access To'),
            'title'     => Mage::helper('safemage_permissions')->__('Allow Access To'),
            'required'  => true,
            'values'    => Mage::getSingleton('safemage_permissions/Source_AccessibleSalesData')->toOptionArray(),
            'value'     => $perm->getAllowAccessTo(),
            'disabled'  => false,
        ));

        $fsSales->addField('sales[allow_own_products_only]', 'select', array(
            'name'      => 'sales[allow_own_products_only]',
            'label'     => Mage::helper('safemage_permissions')->__('Allow to Manage Sales Data for Owned Products only'),
            'title'     => Mage::helper('safemage_permissions')->__('Allow to Manage Sales Data for Owned Products only'),
            'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
            'value'     => $perm->getAllowOwnProductsOnly(),
        ));

        //$form->setValues($this->getRole()->getData());
        $this->setForm($form);
    }
}
