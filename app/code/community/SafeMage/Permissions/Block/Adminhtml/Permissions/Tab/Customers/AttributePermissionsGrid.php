<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Customers_AttributePermissionsGrid
    extends SafeMage_Permissions_Block_Adminhtml_Permissions_Tab_Categories_AttributePermissionsGrid
{
    //protected $_gridType = 'customers[a]';
    //protected $_paramVarName = 'customers';
    protected $_permission = 'customer';

    public function __construct()
    {
        parent::__construct();
        $this->setId('customerAttributePermissionsGrid');
    }

    public function getGridType()
    {
        //return $this->getRequestHelper()->getCustomersVarName() . '[a]';
        return $this->getRequestHelper()->getCustomersGridType();
    }

    public function getParamVarName()
    {
        return $this->getRequestHelper()->getCustomersVarName();
    }

    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/safemage_permissions_ajax/getCustomerAttributePermissions', array('_current'=>true));
    }

    protected function _getMyCollection()
    {
        $collection = Mage::getResourceModel('safemage_permissions/attributeCollection_customer');
        return $collection;
    }
}
