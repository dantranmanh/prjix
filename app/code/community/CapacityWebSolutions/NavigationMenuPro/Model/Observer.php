<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Model_Observer
{
	public function compileLess($observer){			
		/*echo 'test';die;
		if (!file_exists(Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'ajaxsearch')) {
					mkdir(Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'ajaxsearch', 0777, true);
				}
				$path = Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'ajaxsearch'.DS."ajaxsearchtheme.css";
				$category_color = Mage::helper('ajaxsearch/config')->getThemeSetting();
				$popup = Mage::helper('ajaxsearch/config')->getAutocompleteSetting();			
				$layout = Mage::helper('ajaxsearch/config')->getThemeSetting();
				$category_box_background=$category_color['category_box_background'];
				$category_text_color=$category_color['category_text_color'];
				
	
$css = '.mbAjaxSearch span.select-wrapper { color:#'.$category_text_colo.';background-color:#'.$category_box_background.';}.mbAjaxSearch .select-wrapper .holder { color:#'.$category_text_color.'>;}.mbAjaxSearch .select-wrapper .holder:after { border-top-color:#'.$category_text_color.';}#mbAutoSearch .search_autocomplete { width:'.$popup['popup_width'].'px; border:2px solid #'.$layout['border_color'].';}mbAutoSearch .search_autocomplete:before { border-bottom-color:#'.$layout['border_color'].';}#mbAutoSearch ul li { color:#'.$layout['font_color'].';background-color:#'.$layout['background_color'].';border-bottom:1px solid #'.$layout['border_color'].';-webkit-transition:all 0.4s ease-in-ou; -moz-transition:all 0.4s ease-in-out; -o-transition:all 0.4s ease-in-out; -ms-transition:all 0.4s ease-in-out; transition:all 0.4s ease-in-out; }#mbAutoSearch ul li:hover { background-color:#'.$layout['hover_color'].';}#mbAutoSearch ul li .product-name { color:#'.$layout['font_color'].';}#mbAutoSearch ul li .ajxSku { color:#'.$layout['font_color'].';}#mbAutoSearch ul li .ajxDescription { color:#'.$layout['font_color'].';}#mbAutoSearch ul li .review { color:#'.$layout['font_color'].';}#mbAutoSearch ul li .price-box { color:#'.$layout['font_color'].';}#mbAutoSearch .searchText { background-color:#'.$layout['heightlight_color'].';}';


				file_put_contents($path,$css);
		$process = Mage::getModel('index/indexer')->getProcessByCode('catalogsearch_fulltext');
		$process->reindexAll(); 
		*/
	}			
	
}



