<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Source_AccessibleCategoryTabs
{
    protected $_knownTabs = array(
        'General Information' => 'General Information',
        'Display Settings'    => 'Display Settings',
        'Custom Design'       => 'Custom Design',
        'Category Products'   => 'Category Products',
    );

    public function getKnownTabs()
    {
        return $this->_knownTabs;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $tabs = $this->toArray();
        $options = array();
        foreach($tabs as $tabId => $label) {
            $options[]= array('value' => $tabId, 'label' => Mage::helper('safemage_permissions')->__($label));
        }

        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $tabs = $this->getKnownTabs();
        return $tabs;
    }
}
