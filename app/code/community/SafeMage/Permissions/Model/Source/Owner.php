<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Source_Owner extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = Mage::getResourceModel('safemage_permissions/attribute_owner')->getAdminsAsSourceOptions();
        return $this->_options;
    }

    /**
     * Retrieve Catalog Config Singleton
     *
     * @return Mage_Catalog_Model_Config
     */
    protected function _getCatalogConfig() {
        return Mage::getSingleton('catalog/config');
    }
}
