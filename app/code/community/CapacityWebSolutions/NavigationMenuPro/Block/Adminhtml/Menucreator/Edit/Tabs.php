<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreator_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('Menucreator_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('navigationmenupro')->__('Navigation Menu Pro'));
	 
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('navigationmenupro')->__('General'),
          'title'     => Mage::helper('navigationmenupro')->__('General'),
          'content'   => $this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreator_edit_tab_form')->toHtml(),
      ));
	  $this->addTab('form_section_advance', array(
          'label'     => Mage::helper('navigationmenupro')->__('Advance'),
          'title'     => Mage::helper('navigationmenupro')->__('Advance'),
          'content'   => $this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreator_edit_tab_formadvance')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}