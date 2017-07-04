<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Source_AccessibleCustomerTabs
{
    protected $_knownTabs = array(
        'Customer View' => 'Customer View',
        'Account Information' => 'Account Information',
        'Addresses' => 'Addresses',
        'Orders' => 'Orders',
        'Billing Agreements' => 'Billing Agreements',
        'Recurring Profiles (beta)' => 'Recurring Profiles (beta)',
        'Shopping Cart' => 'Shopping Cart',
        'Wishlist' => 'Wishlist',
        'Newsletter' => 'Newsletter',
        'Product Reviews' => 'Product Reviews',
        'Product Tags' => 'Product Tags',
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
