<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Products extends Mage_Adminhtml_Block_Widget_Form
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
        $prodVarName = Mage::helper('safemage_permissions/request')->getProductsVarName();

        $perm = Mage::registry('current_role')->getPermissions('product');
        $form = new Varien_Data_Form();

        $fsStores = $form->addFieldset('fs-store', array('legend'=>Mage::helper('adminhtml')->__('Store View')));
        $fsProducts = $form->addFieldset('fs-prod-prod', array('legend'=>Mage::helper('adminhtml')->__('Accessible Products')));
        $fsTabs = $form->addFieldset('fs-prod-tabs', array('legend'=>Mage::helper('adminhtml')->__('Accessible Product Tabs')));
        $fsAttributes = $form->addFieldset('fs-prod-attr-permissions', array('legend'=>Mage::helper('adminhtml')->__('Manage Attribute Permissions')));

        $storeViewField = Mage::helper('safemage_permissions/form')->addStoreViewField($fsStores, $prodVarName . '[store_ids]');
        if (!Mage::app()->isSingleStoreMode()) {
            $sStoreIds = implode(',', $perm->getStoreIds());
            $storeViewField->setValue($sStoreIds);
        }

        $fsProducts->addType('custom_field', 'SafeMage_Permissions_Block_Adminhtml_Form_CustomField');

        $accessibleProducts = $fsProducts->addField($prodVarName . '[allow_access_to]', 'select', array(
            'name'      => $prodVarName . '[allow_access_to]',
            'label'     => Mage::helper('safemage_permissions')->__('Allow Access To'),
            'title'     => Mage::helper('safemage_permissions')->__('Allow Access To'),
            'required'  => true,
            'values'    => Mage::getSingleton('safemage_permissions/source_accessibleProducts')->toOptionArray(),
            'value'     => $perm->getAllowAccessTo(),
        ));

        $categoryTree = $this->getLayout()
            ->createBlock('safemage_permissions/Adminhtml_Permissions_Tab_Products_CategoryTree')
            ->setData($prodVarName . '[store_ids]', $perm->getStoreIds())
            ->setData($prodVarName . '[category_ids]', $perm->getCategoryIds())
            ->setHtmlId('prod_categories')
            ->setName($prodVarName . '[category_ids]')
            ->setVarNamePostfix('Prod')
        ;
        $categories = $fsProducts->addField('prod_categories', 'custom_field', array(
            'name'      => 'prod_categories',
            'label'     => Mage::helper('safemage_permissions')->__('Accessible Categories'),
            'value_block'     => $categoryTree,
        ));

        $selectedProductsGrid = $this->getLayout()
            ->getBlock('selectedproducts')
            ->setData($prodVarName . '[store_ids]', $perm->getStoreIds())
        ;

        $storesAfter = $this->getLayout()
            ->createBlock('core/template')
            ->setTemplate('safemage/permissions/form/products/stores-after.phtml')
            ->setCategoryTree($categoryTree)
            ->setSelectedProductsGrid($selectedProductsGrid)
            ->setStoreMultiselectId($storeViewField->getId())
            ->setStoreIdsVarName($prodVarName . '[store_ids]')
            ->setCategoryTreeUpdaterVarName('safemageCategoryTreeUpdaterProd')
        ;
        $storeViewField->setAfterElementHtml($storesAfter->toHtml());

        $selectedProducts = $fsProducts->addField('selectedProductsGrid', 'custom_field', array(
            'value_block' => $selectedProductsGrid,
        ));

        $this->setChild('form_after',$this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($accessibleProducts->getHtmlId(), $accessibleProducts->getName())
            ->addFieldMap($categories->getHtmlId(), $categories->getName())
            ->addFieldMap($selectedProducts->getHtmlId(), $selectedProducts->getName())
            ->addFieldDependence($categories->getName(),$accessibleProducts->getName(), 2)
            ->addFieldDependence($selectedProducts->getName(),$accessibleProducts->getName(), 3)
        );

        $permittedActions = $this->getLayout()
            ->createBlock('safemage_permissions/Adminhtml_Form_PermittedActions')
            ->setData(array(
                'allow_create' => $perm->getAllowCreate(),
                'allow_edit' => $perm->getAllowEdit(),
                'allow_delete' => $perm->getAllowDelete()
            ))
            ->setName($prodVarName)
        ;
        $field = $fsProducts->addField('permitted_actions', 'custom_field', array(
            'label'     => Mage::helper('safemage_permissions')->__('Permitted Actions'),
            'value_block'     => $permittedActions,
        ));

        $fsTabs->addField($prodVarName . '[tabs]', 'multiselect', array(
            'name'      => $prodVarName . '[tabs][]',
            'label'     => Mage::helper('safemage_permissions')->__('Accessible Product Tabs'),
            'title'     => Mage::helper('safemage_permissions')->__('Accessible Product Tabs'),
            'required'  => true,
            'values'    => Mage::getSingleton('safemage_permissions/source_accessibleProductTabs')->toOptionArray(),
            'value'     => $perm->getTabs(),
            'disabled'  => false,
            'after_element_html' => '<p class="note">Selected tabs will be visible to the current Role.</p>',
        ));

        $fsAttributes->addType('custom_field', 'SafeMage_Permissions_Block_Adminhtml_Form_CustomField');
        $attrPermissions = $this->getLayout()->getBlock('products.attrpermissions');
        $field = $fsAttributes->addField('attribute_permissions', 'custom_field', array(
            'label_block'     => $attrPermissions,
        ));

        //$form->setValues($this->getRole()->getData());
        $this->setForm($form);
    }
}
