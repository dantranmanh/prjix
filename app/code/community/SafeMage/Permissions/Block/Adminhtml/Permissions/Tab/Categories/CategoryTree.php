<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Categories_CategoryTree
    extends SafeMage_Permissions_Block_Adminhtml_Form_CategoryTree
{
    //protected $_categoryIdsVarName = 'categories[ids]';

    //protected $_storeIdsVarName = 'categories[store_ids]';

    public function getCategoryIdsVarName()
    {
        $varName = Mage::helper('safemage_permissions/request')->getCategoriesVarName();
        return $varName . '[ids]';
    }

    public function getStoreIdsVarName()
    {
        $varName = Mage::helper('safemage_permissions/request')->getCategoriesVarName();
        return $varName . '[store_ids]';
    }

    public function getLoadTreeHtmlUrl()
    {
        $params = $this->getRequest()->getParams();
        return $this->getUrl('*/*/categoriesCategoriesHtml', $params);
    }
}
