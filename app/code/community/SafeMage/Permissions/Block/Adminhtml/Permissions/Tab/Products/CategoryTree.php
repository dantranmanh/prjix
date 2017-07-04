<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Products_CategoryTree
    extends SafeMage_Permissions_Block_Adminhtml_Form_CategoryTree
{
    //protected $_categoryIdsVarName = 'products[category_ids]';

    //protected $_storeIdsVarName = 'products[store_ids]';

    public function getCategoryIdsVarName()
    {
        $varName = Mage::helper('safemage_permissions/request')->getProductsVarName();
        return $varName . '[category_ids]';
    }

    public function getStoreIdsVarName()
    {
        $varName = Mage::helper('safemage_permissions/request')->getProductsVarName();
        return $varName . '[store_ids]';
    }

    public function getLoadTreeHtmlUrl()
    {
        $params = $this->getRequest()->getParams();
        return $this->getUrl('*/*/productsCategoriesHtml', $params);
    }
}
