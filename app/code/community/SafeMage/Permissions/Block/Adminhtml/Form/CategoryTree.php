<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Form_CategoryTree
    extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Categories
{
    //protected $_categoryIdsVarName;
    //protected $_storeIdsVarName;

    public function getCategoryIdsVarName()
    {
        return null;
    }

    public function getStoreIdsVarName()
    {
        return null;
    }

    public function __construct()
    {
        parent::__construct();
        $this->_processHttpParams();
        $this->setTemplate('safemage/permissions/form/category-tree.phtml');
    }

    public function getRequestHelper()
    {
        return Mage::helper('safemage_permissions/request');
    }

    public function getLoadTreeHtmlUrl()
    {
        $params = $this->getRequest()->getParams();
        return $this->getUrl('*/*/categoriesHtml', $params);
    }

    public function isReadonly()
    {
        return false;
    }

    protected function getCategoryIds()
    {
        if ((!$this->getCategoryIdsVarName()) || (!$this->getStoreIdsVarName())) {
            return array();
        }

        $selectedCatIds = $this->getData($this->getCategoryIdsVarName());

        if (Mage::helper('safemage_permissions/config')->getFilterSelectedDataByStoresEnabled()) {
            if ($storeIds = $this->getData($this->getStoreIdsVarName())) {
                $selectedCatIds = Mage::getResourceModel('safemage_permissions/tree')
                    ->filterCategoryIdsByStores($selectedCatIds, $storeIds)
                ;
            }
        }

        return $selectedCatIds;
    }

    public function getRoot($parentNodeCategory = null, $recursionLevel = 3)
    {
        $root = Mage_Adminhtml_Block_Catalog_Category_Tree::getRoot($parentNodeCategory, $recursionLevel);

        if (!$this->getStoreIdsVarName()) {
            return $root;
        }

        if ($storeIds = $this->getData($this->getStoreIdsVarName())) {
            if (!Mage::helper('safemage_permissions/request')->getAllStoresSelected($storeIds)) {
                Mage::getResourceModel('safemage_permissions/tree')->addStoreFilter($root->getChildren(), $storeIds);
            }
        }

        return $root;
    }

    protected function _processHttpParams()
    {
        if ($params = $this->getRequest()->getPost()) {
            $this->addData($params);
        }
    }
}
