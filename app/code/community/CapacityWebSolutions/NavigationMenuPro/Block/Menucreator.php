<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Menucreator extends Mage_Core_Block_Template {
	protected $group_option = '';	
	public function _prepareLayout() 
	{	
		return parent::_prepareLayout();
    }
	public function getMenutype($group_id)
	{
	$group_details = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	$group_menutype = trim($group_details->getMenutype());
	return $group_menutype;
	}
	public function getMenuStatus($group_id)
	{
	$group_details = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	$group_status = trim($group_details->getStatus());
	return $group_status;
	}
	public function getBreakPoint($group_id)
	{
	$group_details = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	$mobilemenuoptions = trim($group_details->getMobilemenuoptions());
	if($this->isJSON($mobilemenuoptions)){
		$mobilemenuoptions = json_decode($mobilemenuoptions, true);
				return $mobilemenuoptions['responsive_breakpoint'];
	}else{
		return '767px';	
	}
	}
	
	public function isJSON($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}
	
	public function get_menu_css($group_id) {
	Mage::app()->getLayout()->getBlock('head')->addJs('js/path/here.js');

	$groupdata = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	$alignment = $groupdata->getPosition();
	$menutype = $groupdata->getMenutype();
	$grouptitletextcolor = $groupdata->getTitletextcolor();
	$grouptitlebgcolor = $groupdata->getTitlebackcolor();
	$textcolor = $groupdata->getItemtextcolor();
	$texthovercolor = $groupdata->getItemtexthovercolor();
	$itembgcolor = $groupdata->getItembgcolor();
	$itembghovercolor = $groupdata->getItembghovercolor();
	$css = '';
	$css .='#menu-'.$group_id.' ul.cwsMenu.'.$alignment.' li { background-color:#'.$itembgcolor.'}';
	$css .='#menu-'.$group_id.' ul.cwsMenu.'.$alignment.' li:hover { background-color:#'.$itembghovercolor.'}';
	$css .='#menu-'.$group_id.' ul.cwsMenu.'.$alignment.' li a { color:#'.$textcolor.'}';
	$css .='#menu-'.$group_id.' ul.cwsMenu.'.$alignment.' li a:hover { color:#'.$texthovercolor.'}';
	return $css;
	}
	
	public function setCssJs($value) {
	
	$head = $this->getLayout()->getBlock('head')->addCss('css/navigationmenupro/group-'.$value.'.css');
	$head->addCss('css/navigationmenupro/group-'.$value.'.css');
		
	}
	public function __getHeadBlock() {
		return Mage::getSingleton('core/layout')->getBlock('navigationmenupro_head');
	}
	
}