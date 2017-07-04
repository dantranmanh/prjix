<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Model_Menucreatorgroup extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('navigationmenupro/menucreatorgroup');
    }
	public function getAllGroup() {
		$groupData = array ();
		$group_collection = Mage::getModel ('navigationmenupro/menucreatorgroup')->getCollection();
			$groupData [] = array (
					'value' => '',
					'label' => 'Please Select Group', 
			);
		foreach ( $group_collection as $group ) {
			$groupData [] = array (
					'value' => $group->getGroupId(),
					'label' => $group->getTitle(), 
			);
		}
		return $groupData;
	}
	
}