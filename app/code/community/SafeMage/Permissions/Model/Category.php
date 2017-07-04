<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Category extends SafeMage_Permissions_Model_Abstract
{
    protected $_entityTypeId = 3;

    protected $_fieldsToEncode = array('store_ids', /*'ids',*/ 'tabs');

    protected $_fieldsToDecode = array('store_ids', 'ids', 'tabs');

    const ALLOW_ACCESS_TO_ALL        = 1;
    const ALLOW_ACCESS_TO_SELECTED   = 3;

    protected function _construct()
    {
        $this->_init('safemage_permissions/category');
    }

    public function getTabsAvailable()
    {
        $tabsAvailable = Mage::getModel('safemage_permissions/Source_AccessibleCategoryTabs')->toArray();
        return $tabsAvailable;
    }

    public function isAllAllowed()
    {
        $isAllowed = self::ALLOW_ACCESS_TO_ALL == $this->getAllowAccessTo();
        return $isAllowed;
    }

    public function isSelectedAllowed()
    {
        $isAllowed = self::ALLOW_ACCESS_TO_SELECTED == $this->getAllowAccessTo();
        return $isAllowed;
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

    protected function _beforeSave()
    {
        $parent = parent::_beforeSave();

        if ($this->getAllowAccessTo() == self::ALLOW_ACCESS_TO_ALL) {
            $this->setIds('');
        }

        return $parent;
    }
}