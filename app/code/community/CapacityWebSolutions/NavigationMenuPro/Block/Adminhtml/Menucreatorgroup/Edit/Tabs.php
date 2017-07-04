<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('Menucreatorgroup_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('navigationmenupro')->__('Navigation Menu Pro Group'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('navigationmenupro')->__('Menu Group'),
          'title'     => Mage::helper('navigationmenupro')->__('Menu Group'),
          'content'   => $this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit_tab_form')->toHtml(),
      ));
	  $this->addTab('rootitem_section', array(
          'label'     => Mage::helper('navigationmenupro')->__('Menu Bar Options'),
          'title'     => Mage::helper('navigationmenupro')->__('Menu Bar Options'),
          'content'   => $this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit_tab_rootitem')->toHtml(),
      ));
	  $this->addTab('megaparent_form_color', array(
          'label'     => Mage::helper('navigationmenupro')->__('Mega Menu Item Options'),
          'title'     => Mage::helper('navigationmenupro')->__('Mega Menu Item Options'),
          'content'   => $this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit_tab_megamenuitem')->toHtml(),
      ));
	  $this->addTab('subitems_form_color', array(
          'label'     => Mage::helper('navigationmenupro')->__('Flyout Options'),
          'title'     => Mage::helper('navigationmenupro')->__('Flyout Options'),
          'content'   => $this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit_tab_submenuitem')->toHtml(),
      ));
	   $this->addTab('suboptions_form_color', array(
          'label'     => Mage::helper('navigationmenupro')->__('Sub Menu Item option'),
          'title'     => Mage::helper('navigationmenupro')->__('Sub Menu Item option'),
          'content'   => $this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit_tab_suboptions')->toHtml(),
      ));
	   $this->addTab('mobile_section', array(
          'label'     => Mage::helper('navigationmenupro')->__('Mobile Menu'),
          'title'     => Mage::helper('navigationmenupro')->__('Mobile Menu'),
          'content'   => $this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit_tab_mobilemenu')->toHtml(),
      ));
	    if ($this->getRequest()->getParam('id')) {
		
			$this->addTab('xml_section', array(
				'label'		=> Mage::helper('navigationmenupro')->__('Menu Embeded Code'),
				'title'		=> Mage::helper('navigationmenupro')->__('Menu Embeded Code'),
				'content'	=> $this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit_tab_codesnipet')->toHtml(),
			));
		}
     
      return parent::_beforeToHtml();
  }
}