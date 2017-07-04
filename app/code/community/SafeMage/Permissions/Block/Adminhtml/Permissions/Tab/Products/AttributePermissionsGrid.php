<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Products_AttributePermissionsGrid
    extends SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Categories_AttributePermissionsGrid
{
    //protected $_gridType = 'p1[a]';
    //protected $_paramVarName = 'p1';
    protected $_permission = 'product';

    public function __construct()
    {
        parent::__construct();
        $this->setId('productAttributePermissionsGrid');
    }

    public function getGridType()
    {
        //return $this->getRequestHelper()->getProductsVarName() . '[a]';
        return $this->getRequestHelper()->getProductsGridType();
    }

    public function getParamVarName()
    {
        return $this->getRequestHelper()->getProductsVarName();
    }

    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/safemage_permissions_ajax/getProductAttributePermissions', array('_current'=>true));
    }

    protected function _getMyCollection()
    {
        $collection = Mage::getResourceModel('safemage_permissions/attributeCollection_product')
            ->addVisibleFilter()
        ;

        return $collection;
    }
}
