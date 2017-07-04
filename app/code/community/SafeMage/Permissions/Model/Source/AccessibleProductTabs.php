<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Source_AccessibleProductTabs
{
    const TABS_CACHE_KEY = 'safemage_permissions_prod_tabs';

    protected $_knownTabs = array(
        'Inventory'        => 'Inventory',
        'Websites'         => 'Websites',
        'Categories'       => 'Categories',
        'Related Products' => 'Related Products',
        'Up-sells'         => 'Up-sells',
        'Cross-sells'      => 'Cross-sells',
        'Product Reviews'  => 'Product Reviews',
        'Product Tags'     => 'Product Tags',
        'Customers Tagged Product' => 'Customers Tagged Product',
        'Custom Options' => 'Custom Options',
        'Associated Products' => 'Associated Products',
    );

    public function prepare()
    {
        $tabs1 = $this->getUnknownTabs();
        $tabs2 = $this->getKnownTabs();
        $tabs = array_merge($tabs1, $tabs2);

        return $tabs;
    }

    public function getUnknownTabs()
    {
        $groups = Mage::getResourceModel('eav/entity_attribute_group_collection');
        $groups->getSelect()->join(
            array('eas' => Mage::getSingleton('core/resource')->getTableName('eav/attribute_set')),
            "eas.attribute_set_id = main_table.attribute_set_id",
            array('entity_type_id')
        );

        $groups
            ->addFieldToFilter('entity_type_id', array('eq' => 4))
            ->addOrder('sort_order', Varien_Data_Collection::SORT_ORDER_ASC)  // CE 1.5 compatibility
        ;

        $options = Mage::helper('safemage_permissions/collection')->toOptionArray($groups, 'attribute_group_name', 'attribute_group_name');
        return $options;
    }

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
        $options = array();
        if ($tabs = $this->toArray()) {
            foreach($tabs as $tabId => $label) {
                $options[]= array('value' => $tabId, 'label' => Mage::helper('safemage_permissions')->__($label));
            }
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
        if (!$this->_load()) {
            $tabs = $this->prepare();
            $this->_save($tabs);
        }

        $tabs = $this->_load();
        return $tabs;
    }

    protected function _save($tabs)
    {
        $json = Zend_Json::encode($tabs);
        Mage::app()->getCache()->save($json, self::TABS_CACHE_KEY);
    }

    protected function _load()
    {
        if ($json = Mage::app()->getCache()->load(self::TABS_CACHE_KEY)) {
            $tabs = Zend_Json::decode($json);
            return $tabs;
        }

        return null;
    }
}
