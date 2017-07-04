<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Model_Category extends Varien_Object
{
    public function checkCagegoryAvailable($cat_id)
	{
	$current_storeid = Mage::app()->getStore()->getStoreId();
	$category = Mage::getModel('catalog/category');
	$category->setStoreId($current_storeid);
	$category = $category->load($cat_id);
	$allow_cat = '0';
	
	/* Check Category Is Available Or not is_active*/
	if(($category->getIsActive() == "1")&&($category->getIncludeInMenu()=="1")){
		$rootCategoryId = Mage::app()->getStore()->getRootCategoryId();
		/*Check Root Category Is available in the Category Path Or not*/
		$pos = strpos($category->getPath(),"/".$rootCategoryId."/");
		if($pos != ''){
			$allow_cat = '1';
			}
		/* Here If the Current Category is the Root Category then Also it will allow*/
		if($rootCategoryId == $cat_id){
			$allow_cat = '1';
		}
		
	}
	return $allow_cat;
	}
	public function getChildCategoryCount($cat_id)
	{
	$current_storeid = Mage::app()->getStore()->getStoreId();
	$rootCategoryId = Mage::app()->getStore()->getRootCategoryId();
	$rootpath = Mage::getModel('catalog/category')
                    ->setStoreId($current_storeid)
                    ->load($rootCategoryId)
                    ->getPath();
	$childCats = Mage::getModel('catalog/category')->setStoreId($current_storeid)
                    ->getCollection()
                    ->addAttributeToSelect('*')
					->addAttributeToFilter('include_in_menu', array('eq' => 1))
					->addAttributeToFilter('is_active', array('eq' => 1))					
					->addAttributeToFilter('parent_id',array('eq' => $cat_id))
                    ->addAttributeToFilter('path', array("like"=>$rootpath."/"."%"));
	return count($childCats->getData());
	}
}