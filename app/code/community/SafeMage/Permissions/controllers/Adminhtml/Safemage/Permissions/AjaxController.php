<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Adminhtml_Safemage_Permissions_AjaxController extends Mage_Adminhtml_Controller_Action
{
    public function preDispatch()
    {
        $this->_getRole();
        return parent::preDispatch();
    }

    public function postDispatch()
    {
        return parent::postDispatch(); // TODO: Change the autogenerated stub
    }

    protected function _renderBlock($name)
    {
        $this->loadLayout();
        $b = $this->getLayout()->getBlock($name);
        $this->getResponse()->setBody($b->toHtml());
    }

    protected function _getRole()
    {
        if ($roleId = $this->getRequest()->getParam('rid')) {
            $role = Mage::getModel('safemage_permissions/role')->load($roleId);
            Mage::register('current_role', $role);
        }
    }

    protected function _renderRole($name)
    {
        $this->loadLayout();
        $html = $this->getLayout()->createBlock(
            'safemage_permissions/adminhtml_permissions_tab_' . $name,
            'adminhtml.permissions.tab.' . $name
        )->toHtml();

        $this->getResponse()->setBody($html);
    }

    public function getUserOwnProductsAction()
    {
        $this->_renderBlock('ownproducts');
    }

    public function getRoleCategoriesAction()
    {
        $this->_renderRole('categories');
    }

    public function getRoleProductsAction()
    {
        $this->_renderRole('products');
    }

    public function getRoleProductsSelectedAction()
    {
        $params = $this->getRequest()->getPost();
        $params = Mage::helper('safemage_permissions/request')->fromRequestParams($params);
        $this->getRequest()->setPost($params);

        $this->_renderBlock('selectedproducts');
    }

    public function getRoleSalesAction()
    {
        $this->_renderRole('sales');
    }

    public function getRoleCustomersAction()
    {
        $this->_renderRole('customers');
    }

    public function getRoleConfigAction()
    {
        $this->_renderRole('config');
    }

    public function categoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('safemage_permissions/Adminhtml_Form_CategoryTree')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }

    protected function _categoriesHtml($name)
    {
        $params = $this->getRequest()->getPost();
        $params = Mage::helper('safemage_permissions/request')->fromRequestParams($params);
        $this->getRequest()->setPost($params);

        $name = ucfirst($name);
        $tree = $this->getLayout()
            ->createBlock('safemage_permissions/Adminhtml_Permissions_Tab_' . $name . '_CategoryTree')
        ;
        $this->getResponse()->setBody($tree->toHtml());
    }

    public function categoriesCategoriesHtmlAction()
    {
        $this->_categoriesHtml('categories');
    }

    public function productsCategoriesHtmlAction()
    {
        $this->_categoriesHtml('products');
    }

    public function getCategoryAttributePermissionsAction()
    {
        $this->_renderBlock('categories.attrpermissions');
    }

    public function getProductAttributePermissionsAction()
    {
        $this->_renderBlock('products.attrpermissions');
    }

    public function getCustomerAttributePermissionsAction()
    {
        $this->_renderBlock('customers.attrpermissions');
    }

    public function getConfigSectionPermissionsAction()
    {
        $this->_renderBlock('config.sectionpermissions');
    }

    protected function _isAllowed()
    {
        return true;
    }
}
