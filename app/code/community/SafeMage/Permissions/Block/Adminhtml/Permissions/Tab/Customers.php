<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Customers extends Mage_Adminhtml_Block_Widget_Form
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
        $custVarName = Mage::helper('safemage_permissions/request')->getCustomersVarName();

        $perm = Mage::registry('current_role')->getPermissions('customer');
        $form = new Varien_Data_Form();

        $fsStores = $form->addFieldset('fs-store', array('legend'=>Mage::helper('adminhtml')->__('Website')));
        $fsCustomers = $form->addFieldset('fs-customer-customer', array('legend'=>Mage::helper('adminhtml')->__('Manage Customers')));
        $fsTabs = $form->addFieldset('fs-customer-tabs', array('legend'=>Mage::helper('adminhtml')->__('Accessible Customer Tabs')));
        $fsAttributes = $form->addFieldset('fs-customer-attr-permissions', array('legend'=>Mage::helper('adminhtml')->__('Manage Attribute Permissions')));

        $websiteViewField = Mage::helper('safemage_permissions/form')->addWebsiteField($fsStores, $custVarName . '[website_ids]');
        $websiteIds = implode(',', $perm->getWebsiteIds());
        $websiteViewField->setValue($websiteIds);

        $fsCustomers->addType('custom_field', 'SafeMage_Permissions_Block_Adminhtml_Form_CustomField');

        $permittedActions = $this->getLayout()
            ->createBlock('safemage_permissions/Adminhtml_Form_PermittedActions')
            ->setData(array(
                'allow_create' => $perm->getAllowCreate(),
                'allow_edit' => $perm->getAllowEdit(),
                'allow_delete' => $perm->getAllowDelete()
            ))
            ->setName($custVarName)
        ;
        $field = $fsCustomers->addField('permitted_actions', 'custom_field', array(
            'label'     => Mage::helper('safemage_permissions')->__('Permitted Actions'),
            'value_block'     => $permittedActions,
        ));

        $fsTabs->addField($custVarName . '[tabs]', 'multiselect', array(
            'name'      => $custVarName . '[tabs][]',
            'label'     => Mage::helper('safemage_permissions')->__('Accessible Customer Tabs'),
            'title'     => Mage::helper('safemage_permissions')->__('Accessible Customer Tabs'),
            'required'  => true,
            'values'    => Mage::getSingleton('safemage_permissions/Source_AccessibleCustomerTabs')->toOptionArray(),
            'value'     => $perm->getTabs(),
            'disabled'  => false,
            'after_element_html' => '<p class="note">Selected tabs will be visible to the current Role.</p>',
        ));

        $fsAttributes->addType('custom_field', 'SafeMage_Permissions_Block_Adminhtml_Form_CustomField');
        $attrPermissions = $this->getLayout()->getBlock('customers.attrpermissions');
        $field = $fsAttributes->addField('attribute_permissions', 'custom_field', array(
            'label_block'     => $attrPermissions,
        ));

        //$form->setValues($this->getRole()->getData());
        $this->setForm($form);
    }
}
