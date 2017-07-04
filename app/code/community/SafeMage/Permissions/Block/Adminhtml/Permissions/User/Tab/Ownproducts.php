<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_User_Tab_Ownproducts
    extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    protected $_massactionBlockName = 'safemage_permissions/adminhtml_permissions_user_tab_ownproducts_massaction';

    protected $_selectedProductsVarName;

    public function __construct()
    {
        parent::__construct();
        $this->setSaveParametersInSession(false);

        $this->_selectedProductsVarName = Mage::helper('safemage_permissions/request')->getUserOwnedProductsVarName();
    }

    public function getSelectedProductsVarName()
    {
        return $this->_selectedProductsVarName;
    }

    protected function _construct()
    {
        $this->_defaultFilter = array('massaction' => 1);
        parent::_construct();
    }

    public function getRequestHelper()
    {
        return Mage::helper('safemage_permissions/request');
    }

    public function getAdmin()
    {
        $userId = $this->getRequest()->getParam('user_id');
        $admin = Mage::getModel('admin/user')->load($userId);
        return $admin;
    }

    public function setCollection($collection)
    {
        $this->_collection = $collection;

        if ($this->isFirstTimeOpened()) {
            $admin = $this->getAdmin();
            $productIds = Mage::getResourceModel('safemage_permissions/attribute_owner')->getOwnedProductIds($admin);

            $this->getMassactionBlock()->setMySelectedProducts($productIds);
            $this->getColumn('massaction')->setSelected($productIds);
        }
    }

    protected function _prepareColumns()
    {
        $this->addColumn($this->getSelectedProductsVarName(), array(
            'type' => 'text',
            'column_css_class' => 'no-display',
            'header_css_class' => 'no-display'
        ));

        $parent = parent::_prepareColumns();
        $this->_fixEditUrl();
        return $parent;
    }

    protected function _fixEditUrl()
    {
        if ($columnAction = $this->getColumn('action')) {
            $actions = $columnAction->getActions();
            foreach ($actions as &$action) {
                if (isset($action['url']['base'])) {
                    if ($action['url']['base'] == '*/*/edit') {
                        $action['url']['base'] = 'adminhtml/catalog_product/edit';
                    }
                }
            }
            $columnAction->setActions($actions);
        }
    }

    public function isFirstTimeOpened()
    {
        $products = $this->getRequest()->getPost('internal_massaction');
        $internalName = $this->getMassactionBlock()->getFormFieldNameInternal();

        return is_null($products);
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->addItem('test', array(
            'label'=> Mage::helper('catalog')->__(' '),
        ));

        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/safemage_permissions_ajax/getUserOwnProducts', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('adminhtml/catalog_product/edit', array(
            'store'=>$this->getRequest()->getParam('store'),
            'id'=>$row->getId())
        );
    }

    protected function _afterToHtml($html)
    {
        $html = parent::_afterToHtml($html);
        $js = $this->getChildHtml('ownproducts.js');
        return $html . $js;
    }
}
