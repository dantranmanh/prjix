<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreator extends Mage_Adminhtml_Block_Template
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_menucreator';
		$this->_blockGroup = 'navigationmenupro';
		$this->_headerText = Mage::helper('navigationmenupro')->__('Navigation Menu Pro Management');
		parent::__construct();
	}
	public function group_menu_tree()
	{
			
		$groupcollection = Mage::getModel('navigationmenupro/menucreatorgroup')->getCollection()
		->setOrder("group_id","asc");
		$menugroup_backend = $groupcollection->getData();
		$menubackend = "<div id=navmenu class=navmenusorted>";
		foreach ($menugroup_backend as $key => $group) {
			
		$group_id = $group['group_id'];
		$group_status = $group['status'];
		if($group_status == "1")
		{
			$status = ' enabled';
		}else if($group_status == "2")
		{
			$status = ' disabled';
		}
			
		if($group_id != "0")
		{
			$group_details = Mage::getModel('navigationmenupro/menucreatorgroup')->load($group_id);
			$editgroup_url = Mage::helper("adminhtml")->getUrl("adminhtml/menucreatorgroup/edit/",array("id" => $group_id));
			/* Add Li class 'mjs-nestedSortable-no-nesting' On the Group Li so can not add the sub child on the Group Li*/
			$menubackend .= "<h2 class='groupTitle' id=".$group_id."><a href=".$editgroup_url." title=".$group_details->getTitle()." class='edit'>Edit</a>".$group_details->getTitle()."</h2>";
			$menubackend .= "<ol class='sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded groupid-".$group_id.' '.$status."' id=groupid-".$group_id.">";
			$menubackend .= Mage::getModel("navigationmenupro/menucreator")->getMenuTree($group_id);
			$menubackend .= "</ol>";
		}
		}
		$menubackend .= "</div>";
	return $menubackend;
	}
}