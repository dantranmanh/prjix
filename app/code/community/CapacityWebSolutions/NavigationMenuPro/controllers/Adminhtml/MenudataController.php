<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Adminhtml_MenudataController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction() {
	$this->_initAction()->renderLayout();
	}
	/*Display All the Parent Items On the Form Parent Item Drop Down*/
	public function parentAction()
	{
	$params = $this->getRequest()->getParams();
	$groupId = $this->getRequest()->getParam('group_id');
	$current_menu_id = $this->getRequest()->getParam('current_menu');
	$Parent_item = Mage::getModel("navigationmenupro/menucreator")->getParentItems($groupId,$current_menu_id);
	$this->getResponse()->setBody(json_encode($Parent_item));
	}
	public function addsubparentAction()
	{
	$params = $this->getRequest()->getParams();
	$groupId = $this->getRequest()->getParam('group_id');
	$current_menu_id = $this->getRequest()->getParam('current_menu');
	$Parent_item = Mage::getModel("navigationmenupro/menucreator")->getAddSubParentItems($groupId,$current_menu_id);
	//return $Parent_item;
	$this->getResponse()->setBody(json_encode($Parent_item));
	}
	public function refreshmenuAction()
	{
		$dir = Mage::helper("navigationmenupro")->getDirectoryPath();
		$message = "Menu Refresh Successfully completed!";
		$refresh = false;
		try {
			$files = glob($dir . "*" ); // get all file names
			if(!empty($files))
			{
			foreach($files as $file){ // iterate files
				if(is_file($file)) {
					$result = unlink($file); // delete file
					if ($result) {
						$refresh = true;
					}
				}
			}	
			}else
			{
			$refresh = true;	
			}
			
		} catch (Exception $e) {
			Mage::log($e, null, 'navigationmenu.log');
		}
		if (!$refresh) {
			$message = "Menu is not refresh successfully!";
		}
		Mage::app()->getResponse()->setBody($message);
		
	}
	public function _isAllowed()
		{
			return true;
		}
}