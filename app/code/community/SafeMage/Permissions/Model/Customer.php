<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Customer extends SafeMage_Permissions_Model_Abstract
{
    protected $_entityTypeId = 1;

    protected $_fieldsToEncode = array('website_ids', 'store_ids', 'tabs');

    protected $_fieldsToDecode = array('website_ids', 'store_ids', 'tabs');

    protected function _construct()
    {
        $this->_init('safemage_permissions/customer');
    }

    public function getTabsAvailable()
    {
        $tabsAvailable = Mage::getModel('safemage_permissions/Source_AccessibleCustomerTabs')->toArray();
        return $tabsAvailable;
    }

    public function canCreate()
    {
        $can = (bool)$this->getAllowCreate();
        return $can;
    }

    public function canEdit()
    {
        $can = (bool)$this->getAllowEdit();
        return $can;
    }

    public function canDelete()
    {
        $can = (bool)$this->getAllowDelete();
        return $can;
    }
}