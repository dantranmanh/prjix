<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_menucreatorgroup';
    $this->_blockGroup = 'navigationmenupro';
    $this->_headerText = Mage::helper('navigationmenupro')->__('Navigation Menu Pro Group Management');
    $this->_addButtonLabel = Mage::helper('navigationmenupro')->__('Add Group');
    parent::__construct();
  }
}