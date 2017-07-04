<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Helper_Data extends Mage_Core_Helper_Abstract
{
protected $groups=array();
protected $relations=array();
public $menu_level = 0;
public $level = 0;
protected $group_option = '';	
public function getallMenuTypes()
	{
		return array(
			'1' => 'CMS Page',
			'2' => 'Category Page',
			'3' => 'Static Block',
			'4' => 'Product Page',
			'5' => 'Custom Url',
			'6' => 'Alias [href=#]',
			'7'=>	'Group'
		);
	}
	public function getallLinks()
	{
		return array(
			'account' 	=> 'My Account',
			'cart' 		=> 'My Cart',
			'wishlist' 	=> 'My Wishlist',
			'checkout' 	=> 'Checkout',
			'login' 	=> 'Login',
			'logout' 	=> 'Logout',
			'register' 	=> 'Register',
			'contact' 	=> 'Contact Us'
		);
	}
	public function getDirection()
	{
		return array(
			'ltr' 		=> 'Left To Right',
			'rtl' 	=> 'Right To Left',		
		);
	}
	
	public function getstore_swatcher()
	{
	$store_info	=	Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true);
	return $store_info;
		
	}
	public function getPermission()
	{
		
		$this->groups[]=array('value'=>'-2','label'=>'Public');
		$this->groups[]=array('value'=>'-1','label'=>'Registered');
		$collection = Mage::getModel('customer/group')->getCollection();
		foreach($collection as $value)
		{
			$this->groups[] = array(
					'value'=>$value->getCustomerGroupId(),
					'label' => $value->getCustomerGroupCode()
			);
		}
		return $this->groups;
	}
	public function getRelation()
	{
		$this->relations[]=array('value'=>'alternate','label'=>'alternate');
		$this->relations[]=array('value'=>'author','label'=>'author');
		$this->relations[]=array('value'=>'bookmark','label'=>'bookmark');
		$this->relations[]=array('value'=>'help','label'=>'help');
		$this->relations[]=array('value'=>'license','label'=>'license');
		$this->relations[]=array('value'=>'next','label'=>'next');
		$this->relations[]=array('value'=>'nofollow','label'=>'nofollow');
		$this->relations[]=array('value'=>'noreferrer','label'=>'noreferrer');
		$this->relations[]=array('value'=>'prefetch','label'=>'prefetch');
		$this->relations[]=array('value'=>'prev','label'=>'prev');
		$this->relations[]=array('value'=>'search','label'=>'search');
		$this->relations[]=array('value'=>'tag','label'=>'tag');
		return $this->relations;
	}
	public function getPermissionforgrid()
	{
	$permission = array();
	$permission["-2"] = 'Public';
	$permission["-1"] = 'Registered';
	$collection = Mage::getModel('customer/group')->getCollection();
		foreach($collection as $value)
		{
		$permission[$value->getCustomerGroupId()] = $value->getCustomerGroupCode();
		}
		return $permission;
	}
	public function getParentIds($menu_id)
	{
		$menu = Mage::getModel('navigationmenupro/menucreator');
		$p_id=$menu->load($menu_id)->getParentId();
		$p_ids=$p_id;
		//Stop this function when it parent is root node
		if($p_id!=0)
		{	
			$p_ids=$p_ids."-".$this->getParentIds($p_id);
		}
		return $p_ids;
	}
	public function getMenuSpace($menu_id)
	{
		$space="";
		$parentIds=explode("-", $this->getParentIds($menu_id));
		for($i=1; $i<count($parentIds);$i++)
		{
			$space = $space."--";
		}
		return $space;
	}
	public function getlevel($menu_id,$level)
	{
		$menu = Mage::getModel('navigationmenupro/menucreator');
		$p_id=$menu->load($menu_id)->getParentId();
		$parent_menu = $menu->load($p_id);
		if($p_id!=0)
		{	
			
		$this->menu_level = $level+1;
		$this->getlevel($p_id,$this->menu_level);
		}else
		{
		$level = '0';
		return $level;
		}
		
		return $this->menu_level;
	}
	public function columnLayout()
	{
		return array(
			'' => 'Please Select Sub Column Layout',
			'no-sub' => 'No Sub Item',
			'column-1' => '1 Column Layout',
			'column-2' => '2 Column Layout',
			'column-3' => '3 Column Layout',
			'column-4' => '4 Column Layout',
			'column-5' => '5 Column Layout',
			'column-6' => '6 Column Layout',
			'column-7' => '7 Column Layout',
			'column-8' => '8 Column Layout',
		);
	}
	public function getGroupMenuType(){
	return array(
			'' => 'Please Select Menu Type',
			'mega-menu' => 'Mega Menu',
			'smart-expand' => 'Smart Expand',
			'always-expand' => 'Always Expand',
			'list-item' => 'List Item'
		);
	}
	public function getAlignment(){
	return array(
			'left' => 'Left',
			'right' => 'Right',
			'full-width' => 'Full Width',
		);
	}
	public function getMenuLevel(){
	return array(
			'' => 'Please Select Level',
			'0' => 'Only Root Level',
			'1' => 'One Level',
			'2' => 'Second Level',
			'3' => 'Third Level',
			'4' => 'Fourth Level',
			'5' => 'Fifth Level',
		);
	}
	public function getShowHideTitle(){
	return array(
			'' => 'Please Select Show Hide Menu Title',
			'1' => 'Hide Group Title',
			'2' => 'Show Group Title',
		);
	}
	
	public function getmassMenuLevel(){
	return array(
			'0' => 'Only Root Level',
			'1' => 'One Level',
			'2' => 'Second Level',
			'3' => 'Third Level',
			'4' => 'Fourth Level',
			'5' => 'Fifth Level',
		);
	}
	public function getTemplatePath()
	{
		$storeId = Mage::app()->getStore()->getStoreId();
		$storeCode = Mage::app()->getStore()->getCode();
		$current_theme_template = Mage::getStoreConfig('design/theme/template', $storeId);
		if($current_theme_template=='')
		{
			$current_theme_template = 'default';
		}
		$current_package = Mage::getSingleton('core/design_package')->getPackageName();
		$template_dir = Mage::getBaseDir('app').DIRECTORY_SEPARATOR.'design'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'base'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'navigationmenupro'.DIRECTORY_SEPARATOR;
		return $template_dir;
	}
	public function getDirectoryPath()
	{
		$storeId = Mage::app()->getStore()->getStoreId();
		$storeCode = Mage::app()->getStore()->getCode();
		$current_theme_template = Mage::getStoreConfig('design/theme/template', $storeId);
		if($current_theme_template=='')
		{
			$current_theme_template = 'default';
		}
		$current_package = Mage::getSingleton('core/design_package')->getPackageName();
		$dir = Mage::getBaseDir('app').DIRECTORY_SEPARATOR.'design'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'base'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'navigationmenupro'.DIRECTORY_SEPARATOR.'static'.DIRECTORY_SEPARATOR;
		return $dir;
	}
	public function isDevelopmentEnabled() {
		return Mage::getStoreConfig('navigationmenupro/optimize_performance/developer_mode_enable_disable',Mage::app()->getStore());
	}
	public function isEnabled() {
	return Mage::getStoreConfig('navigationmenupro/general/module_enable_disable',Mage::app()->getStore());
	}
	public function getBreakPoint() {
	return Mage::getStoreConfig('navigationmenupro/general/responsive_break_point');
	}
	
	public function getCurrentGroupId() {
	$group_id = Mage::getModel("navigationmenupro/menuitem")->getCurrentGroupId();
	return $group_id;
	}
	public function get_menu_items($group_id) {
	$this->group_option = '';
	$group_details = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	if($group_details->getStatus() == "1"){
		
		/* Here set the group Position of the group*/
		$group_position = $group_details->getPosition();
		$group_menutype = $group_details->getMenutype();
		if(($group_menutype == 'mega-menu'))
		{
		$this->group_option = $group_menutype." ".$group_position;
		}else
		{
		$this->group_option = $group_menutype;
		}
		
		/* Check Menu Title Display Or not*/
		
		$group_level = $group_details->getLevel();
		$direction = $group_details->getDirection();
		if($direction=='rtl'){
			$direction_css = 'rtl';
		}elseif($direction=='ltr'){
			$direction_css = 'ltr';
		}
		/*
		if($group_menutype == 'list-item') {
			
			if($direction_css!=''){
					$menufront = "<nav id='cwsMenu-".$group_id."' class='".$direction_css."'>";
				}else{
					$menufront = "<nav id='cwsMenu-".$group_id."'>";
				}
		} else {
				if($direction_css!=''){
					$menufront = "<nav id='cwsMenu-".$group_id."' class='cwsMenuOuter ".$direction_css." '>";		
				}else{
					$menufront = "<nav id='cwsMenu-".$group_id."' class='cwsMenuOuter'>";
				}
			
		}*/
		if($group_menutype == 'list-item') {
			if($direction_css!=''){
					$menufront = "<nav id='cwsMenu-".$group_id."' class='".$direction_css."'>";
				}else{
					$menufront = "<nav id='cwsMenu-".$group_id."'>";
				}
		} else if($group_menutype == 'mega-menu') {
				if($direction_css!=''){
					$menufront = "<nav id='cwsMenu-".$group_id."' class='navigation cwsMenuOuter ".$group_position." ".$direction_css."' role='navigation'>";
		
				}else{
					$menufront = "<nav id='cwsMenu-".$group_id."' class='cwsMenuOuter'>";
				}
		} else {
				if($direction_css!=''){
					$menufront = "<nav id='cwsMenu-".$group_id."' class='navigation cwsMenuOuter ".$direction_css."' role='navigation'>";
		
				}else{
					$menufront = "<nav id='cwsMenu-".$group_id."' class='cwsMenuOuter'>";
				}
		}

			if($group_details->getShowhidetitle() == "2"){
				$menufront .= '<h3 class="menuTitle">'.$group_details->getTitle().'</h3>';
			}
			if($group_menutype != 'list-item'){
				$menufront .="<ul class='cwsMenu ".$this->group_option."'>";
			} else {
				$menufront .="<ul>";
			}
			$menufront .= Mage::getModel("navigationmenupro/menuitem")->getMenuContent($group_id);
			$menufront .= "</ul>";
			$menufront .= "</nav>";
			return $menufront;
		
		} else {
			return;
		}
	
	}
	public function getStaticMenu($groupId)
	{
		$storeCode = Mage::app()->getStore()->getCode();
		$website_id = Mage::app()->getWebsite()->getId(); 
		$menu_customer = Mage::getModel('navigationmenupro/customer');
		$permission = $menu_customer->getUserPermission();
		$session = Mage::getSingleton('customer/session', array('name'=>'frontend'));
		if ($session->isLoggedIn()) {
		$customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
		}else
		{
		$customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
		}
		$template_dir = $this->getTemplatePath();
		$dir = $this->getDirectoryPath();
		if (!is_dir($template_dir)) {
		mkdir($template_dir); 
		}
			if (!is_dir($dir)) {
			mkdir($dir); 
			}

		$template = 'navigationmenupro' . DS . 'static' . DS . 'navigationmenu-w-' . $website_id . 's-' . $storeCode
				. '-g-' . $groupId . 'customer-' . $customerGroupId . '.phtml';

		$templateBlock = Mage::app()->getLayout()->createBlock('core/template')->setTemplate($template);

		if ($templateBlock) {
			return $templateBlock->toHtml();
		} else {
			return '';
		}
	}
	public function getFontTransform(){
		return array(
			'inherit' => 'Inherit',
			'uppercase' => 'Uppercase',
			'lowercase' => 'Lowercase',
			'capitalize' => 'Capitalize'
			
		);
	}
	public function getSubLevelColor(){
		return array(
			'darken' => 'Darken',
			'lighten' => 'Lighten'
		);
	}
	
}