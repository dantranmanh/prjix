<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Model_Mysql4_Menucreator_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('navigationmenupro/menucreator');
    }
	
}