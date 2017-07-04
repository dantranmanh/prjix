<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Categories extends Mage_Adminhtml_Block_Widget_Form
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
        $catVarName = Mage::helper('safemage_permissions/request')->getCategoriesVarName();

        $perm = Mage::registry('current_role')->getPermissions('category');
        $form = new Varien_Data_Form();

        $fsStores = $form->addFieldset('fs-store', array('legend' => Mage::helper('safemage_permissions')->__('Store View')));
        $fsCategories = $form->addFieldset('fs-cat-cat', array('legend' => Mage::helper('safemage_permissions')->__('Accessible Categories')));
        $fsTabs = $form->addFieldset('fs-cat-tabs', array('legend' => Mage::helper('safemage_permissions')->__('Accessible Category Tabs')));
        $fsAttributes = $form->addFieldset('fs-cat-attr-permissions', array('legend' => Mage::helper('safemage_permissions')->__('Manage Attribute Permissions')));

        $storeViewField = Mage::helper('safemage_permissions/form')->addStoreViewField($fsStores, $catVarName . '[store_ids]');
        if (!Mage::app()->isSingleStoreMode()) {
            $sStoreIds = implode(',', $perm->getStoreIds());
            $storeViewField->setValue($sStoreIds);
        }

        $fsCategories->addType('custom_field', 'SafeMage_Permissions_Block_Adminhtml_Form_CustomField');
        $fsCategories->addType('permitted_actions', 'SafeMage_Permissions_Block_Adminhtml_Form_PermittedActions');

        $accessibleCategories = $fsCategories->addField($catVarName . '[allow_access_to]', 'select', array(
            'name'      => $catVarName . '[allow_access_to]',
            'label'     => Mage::helper('safemage_permissions')->__('Allow Access To'),
            'title'     => Mage::helper('safemage_permissions')->__('Allow Access To'),
            'required'  => true,
            'values'    => Mage::getSingleton('safemage_permissions/source_accessibleCategories')->toOptionArray(),
            'value'     => $perm->getAllowAccessTo(),
        ));

        $categoryTree = $this->getLayout()
            ->createBlock('safemage_permissions/Adminhtml_Permissions_Tab_Categories_CategoryTree')
            ->setData($catVarName . '[store_ids]', $perm->getStoreIds())
            ->setData($catVarName . '[ids]', $perm->getIds())
            ->setHtmlId('cat_categories')
            ->setName($catVarName . '[ids]')
            ->setVarNamePostfix('Category')
            ->setCopyCbToParents(true)
        ;

        $categories = $fsCategories->addField('cat_categories', 'custom_field', array(
            'name'      => 'cat_categories',
            'label'     => Mage::helper('safemage_permissions')->__('Accessible Categories'),
            'value_block'     => $categoryTree,
        ));

        $storesAfter = $this->getLayout()
            ->createBlock('core/template')
            ->setTemplate('safemage/permissions/form/categories/stores-after.phtml')
            ->setCategoryTree($categoryTree)
            ->setStoreMultiselectId($storeViewField->getId())
            ->setStoreIdsVarName($catVarName . '[store_ids]')
            ->setCategoryTreeUpdaterVarName('safemageCategoryTreeUpdaterCategory')
        ;
        $storeViewField->setAfterElementHtml($storesAfter->toHtml());

        $this->setChild('form_after',$this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($accessibleCategories->getHtmlId(), $accessibleCategories->getName())
            ->addFieldMap($categories->getHtmlId(), $categories->getName())
            ->addFieldDependence($categories->getName(), $accessibleCategories->getName(), 3)
        );

        $permittedActions = $this->getLayout()
            ->createBlock('safemage_permissions/Adminhtml_Form_PermittedActions')
            ->setData(array(
                'allow_create' => $perm->getAllowCreate(),
                'allow_edit' => $perm->getAllowEdit(),
                'allow_delete' => $perm->getAllowDelete()
            ))
            ->setName($catVarName)
        ;
        $field = $fsCategories->addField('permitted_actions', 'custom_field', array(
            'label'     => Mage::helper('safemage_permissions')->__('Permitted Actions'),
            'value_block'     => $permittedActions,
        ));

        $fsTabs->addField($catVarName . '[tabs]', 'multiselect', array(
            'name'      => $catVarName . '[tabs][]',
            'label'     => Mage::helper('safemage_permissions')->__('Accessible Category Tabs'),
            'title'     => Mage::helper('safemage_permissions')->__('Accessible Category Tabs'),
            'required'  => true,
            'values'    => Mage::getSingleton('safemage_permissions/Source_AccessibleCategoryTabs')->toOptionArray(),
            'value'     => $perm->getTabs(),
            'disabled'  => false,
            'after_element_html' => '<p class="note">Selected tabs will be visible to the current Role.</p>',
        ));

        $fsAttributes->addType('custom_field', 'SafeMage_Permissions_Block_Adminhtml_Form_CustomField');
        $attrPermissions = $this->getLayout()->getBlock('categories.attrpermissions');
        $field = $fsAttributes->addField('attribute_permissions', 'custom_field', array(
            'label_block'     => $attrPermissions,
        ));

        //$form->setValues($this->getRole()->getData());
        $this->setForm($form);
    }
}
