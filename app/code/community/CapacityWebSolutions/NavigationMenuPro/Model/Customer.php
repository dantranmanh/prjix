<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Model_Customer extends Varien_Object
{
    public function isLoggedIn()
    {
        $session = Mage::getSingleton('customer/session', array('name'=>'frontend'));
		$customer_data = Mage::getModel('customer/customer')->load($session->id);
		if($session->isLoggedIn()){
			return 1;
		} else {
		return 0;
		
		}
	
    }
	public function getUserPermission()
	{
		$permission = array(); 
		$permission [] = -2; /* For Public Menu Items*/
		$customerGroup = null;
		$session = Mage::getSingleton('customer/session', array('name'=>'frontend'));
		if ($session->isLoggedIn()) {
			$customerGroup = Mage::getSingleton('customer/session')->getCustomerGroupId();
			$permission [] = -1;/* For Register User Menu Items*/
			$permission [] = $customerGroup;
		} else {
			$permission [] = Mage::getSingleton('customer/session')->getCustomerGroupId();
		}
		return $permission;
	}
}