<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Model_Product extends Varien_Object
{
    public function checkProductavailable($product_id)
	{
	$current_storeid = Mage::app()->getStore()->getStoreId();
	$product = Mage::getModel('catalog/product');
	$product->setStoreId($current_storeid);
	$product = $product->load($product_id);
	$pro_webiste = $product->getWebsiteIds();
	$website_id = Mage::app()->getWebsite()->getId();
	$allow_pro = '0';
	/* Check Product is Enable Or Disable
	Check the Product Visibility is not Visible Individually
	*/
	
	if(($product->getStatus() == "1") && ($product->getVisibility() != "1")){
	foreach($pro_webiste as $key => $value):
		if($value == $website_id)
		{
		$allow_pro = '1';
		}
	endforeach;
	}
	return $allow_pro;
	}
}