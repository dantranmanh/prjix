<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Model_Menuitem extends Mage_Core_Model_Abstract
{
	protected $optionData = "";
	protected $category_list = array();
	protected $item_available = "";
	protected $label_class = "";
	protected $active_class = "";
	protected $item_autosub_cat = "";
	protected $url = "";
	protected $has_child_element = "";
	protected $has_smart_expand = "";
	protected $autosub_has_child_element = "";
	protected $autosub_has_smart_expand = "";
	protected $link_title = "";
	protected $link_relation = "";
	protected $item_target = "";
	protected $column_layout_align = "";
	protected $static_block_status = array();
	protected $static_block_count = "";
	protected $sub_items_available = array();
	protected $my_cat_image_type = "";
	protected $static_blcok_class = "";
	public function _construct()
    {
        parent::_construct();
        $this->_init('navigationmenupro/menucreator');
    }
	public function getMenuGroup()
	{
	return Mage::getModel('navigationmenupro/menucreator')->getCollection()->addFieldToSelect('group_id')->distinct(true);
	}
	public function getMenuitem()
    {
    	$menu_items=Mage::getModel('navigationmenupro/menucreator')->getCollection()->setOrder("group_id","asc")->setOrder("position","asc");
    	return $menu_items;
    }
	public function getChildMenuCollection($parentId)
    {
		$current_storeid = Mage::app()->getStore()->getStoreId();
    	$menu_customer = Mage::getModel('navigationmenupro/customer');
		$permission = $menu_customer->getUserPermission();		
		$chilMenu = Mage::getModel('navigationmenupro/menucreator')->getCollection()->setOrder("position","asc");
    	$chilMenu->addFieldToFilter('status','1');
        $chilMenu->addFieldToFilter('parent_id',$parentId);
		$chilMenu->addFieldToFilter('storeids', array(array('finset' => $current_storeid)));
					/*Filter Collection By User Permission */
		$chilMenu->addFieldToFilter('permission', array('in' => array($permission)));
        return $chilMenu;
    }
	public function getchild($parentID)
	{
		$childCollection=$this->getChildMenuCollection($parentID);
		foreach($childCollection as $value){
			$menuId = $value->getMenuId();
			//Check this menu has child or not
			$this->optionData = Mage::helper("navigationmenupro")->getMenuSpace($menuId);
			$this->parentoption[$menuId] = array('title' => '----' . $this->optionData['blank_space'] . $value->getTitle(), 'group_id' => $value->getGroupId(), 'level' => $this->optionData['level']);
			$hasChild = $this->getChildMenuCollection($menuId);
			if(count($hasChild)>0)
			{
				$this->getchild($menuId);
			}
		}
	}
	
	
	function getCategorieslistform($parentId, $isChild){
    $allCats = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('parent_id',array('eq' => $parentId))
                ->addAttributeToSort('position', 'asc');
               
    //$class = ($isChild) ? "sub-cat-list" : "cat-list";

    
    foreach($allCats as $category)
    {
	if($category->getLevel() > 2)
	{	$lable = '';
		for($i=2;$i<=$category->getLevel();$i++)
		{
		$lable .= "\t".' -';
		}
	}
	$this->category_list[] = array(
                    'value' => $category->getId(),
                    'label' => $lable . " ".$category->getName(),
                );
    	if($class == "sub-cat-list")
		{
		$html .= '<option value="'.$category->getId().'">'.$lable." ".$category->getName().' </option>';
		}else if($class == "cat-list")
		{
		$html .= '<option value="'.$category->getId().'">'.$lable." ".$category->getName().'</option>';
		}
		   /*Remove Ul & Li End*/         
    	 $lable = '';
		$subcats = $category->getChildren();
        if($subcats != ''){
            $html .= $this->getCategorieslistform($category->getId(), true);
        }
    
    }
	return $this->category_list;
    //return $html;
}
	function getCategorieslist($parentId, $isChild){
    $allCats = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('parent_id',array('eq' => $parentId))
                ->addAttributeToSort('position', 'asc');
               
    $class = ($isChild) ? "sub-cat-list" : "cat-list";
    
    foreach($allCats as $category)
    {
	if($category->getLevel() > 2)
	{	$lable = '';
		for($i=2;$i<=$category->getLevel();$i++)
		{
		$lable .= "\t".' -';
		}
	}

    	if($class == "sub-cat-list")
		{
		$html .= '<option value="'.$category->getId().'">'.$lable." ".$category->getName().' </option>';
		}else if($class == "cat-list")
		{
		$html .= '<option value="'.$category->getId().'">'.$lable." ".$category->getName().'</option>';
		}
		   /*Remove Ul & Li End*/         
    	 $lable = '';
		$subcats = $category->getChildren();
        if($subcats != ''){
            $html .= $this->getCategorieslist($category->getId(), true);
        }
    
    }
    return $html;
}


public function getMenuContent($group_id){
	//echo 'getMenuContent';
	$current_storeid = Mage::app()->getStore()->getStoreId();
	$menu_customer = Mage::getModel('navigationmenupro/customer');
	$permission = $menu_customer->getUserPermission();

	$allParent = Mage::getModel('navigationmenupro/menucreator')->getCollection()
                ->addFieldToFilter('parent_id',"0")
				->setOrder("position","asc")
				/*->setOrder("created_time","asc")*/
				->addFieldToFilter('group_id',$group_id)
				/*Only Enabled Item will be list in the menu item*/
				->addFieldToFilter('status',"1")
				/*Filter Collection By Store Id*/
				->addFieldToFilter('storeids', array(array('finset' => $current_storeid)))
				/*Filter Collection By User Permission */
				->addFieldToFilter('permission', array('in' => array($permission)))
				/*Filter Collection By Menu Type Group We are not allow to Use Group As Main Parent Menu Item */
				->addFieldToFilter('type', array('neq' => '7'));
	/*echo '<pre>';
	print_R($allParent->getData());
	die;*/
	$group_details = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	$group_menutype = $group_details->getMenutype();
	$group_level = $group_details->getLevel();

	$i = 0;
	$len = count($allParent);
	$action = Mage::app()->getFrontController()->getRequest()->getActionName();
	$module = Mage::app()->getFrontController()->getRequest()->getModuleName();
	$controller = Mage::app()->getFrontController()->getRequest()->getControllerName();
	
	$menu_item_count = 0;
	$html = isset($html) ? $html : '';
	foreach($allParent as $item)
    {
	$this->active_class = '';
	$this->label_class = '';
	$this->url = '';
	$this->has_child_element = '';
	$this->has_smart_expand = '';
	
	$this->item_available = '';
	$this->item_autosub_cat = '';
	$this->column_layout_align = '';
	$image_tag = '';
	$image_url = '';
	$staticblock_active = '';
	$this->link_title = '';
	$this->link_relation = '';
	
	$this->item_target = '';
	$parent_status = '';
	$add_custom_class = '';
	$this->static_blcok_class = '';
	$space = Mage::helper("navigationmenupro")->getMenuSpace($item->getMenuId());
	$hasChild = $this->getChildMenuCollection($item->getMenuId());
	/* Call the below function to check the static block status of the child & parent element.*/
	$sub_static_block_status = $this->getChildStaticblockStatus($item->getMenuId());
	$count_submenu_item = $this->getChildCount($item->getMenuId());
	/* Here Sub Item available is check the sub item is available for the current store or not.*/
	$subitemsavailable = $this->subitemsavailable($item->getMenuId());
	if(($item->getType() == "1"))
	{
	/* Check CMS Page is Active & From the Current Store Visible Or not*/
	$page_active_check = Mage::getModel('cms/page')->setStoreId($current_storeid)->load($item->getCmspageIdentifier())->getIsActive();
	 if($page_active_check == "1")
	 {
	  $this->item_available = "1";
	  /* If CMS page is home page then no need to add the page Identifier.*/
	  if($item->getCmspageIdentifier() != 'home')
	  {
	  $this->url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).$item->getCmspageIdentifier().'/'; 
	  }else
	  {
	  $this->url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
	  }
	 }else 
	 {
	 $this->item_available = "0";
	 $this->url = '';
	 }
	 if(Mage::app()->getFrontController()->getRequest()->getRouteName() == 'cms')
	 {
		if(Mage::getSingleton('cms/page')->getIdentifier() == $item->getCmspageIdentifier())
		{
			$this->active_class = ' active';
		}
	
	 }
	}else if(($item->getType() == "2"))
	{
	/* For Category Pages*/
		$cat_id = $item->getCategoryId();
		$allow_cat = Mage::getModel('navigationmenupro/category')->checkCagegoryAvailable($cat_id);
	
		$category = Mage::getModel('catalog/category');
		$category->setStoreId($current_storeid);
		$category = $category->load($cat_id);
		$collectionProduct = Mage::getModel('catalog/layer')->setCurrentCategory($category)->getProductCollection();
		$countCategory = $collectionProduct->getSize();
		$rootCategoryId = Mage::app()->getStore()->getRootCategoryId();
		if(($category->getId()) && ($allow_cat == "1") && $countCategory > 0) {
		$this->item_available = "1";
			if($category->getLevel() != '1')
				{
				$this->url = $category->getUrl($category);
				}else
				{
				$this->url = "#";
				}
				
			}else
			{
			$this->item_available = "0";
				$this->url = "";
			}
			if(Mage::registry('current_category'))
			{
			if(Mage::registry('current_category')->getId()==$cat_id)
			{
			$this->active_class = ' active';
			}
			}
			
	}
	else if(($item->getType() == "3"))
	{
	/* For Static Blocks*/
	if($item->getStaticblockIdentifier() != '')
	{
	/* Static block is active for the current store then add into the menu item*/
	$active = Mage::getModel('cms/block')->setStoreId($current_storeid)->load($item->getStaticblockIdentifier())->getIsActive();
		if ($active == 1){
		$this->item_available = "1";
		$this->static_blcok_class = ' cmsbk';
		}else
		{
		$this->item_available = "0";
		$this->static_blcok_class = '';
		}
	
	}
	
	}
	/* For Product Pages*/
	else if(($item->getType() == "4"))
	{ 
	$pro_id = $item->getProductId();
	$allow_pro = Mage::getModel('navigationmenupro/product')->checkProductavailable($pro_id);
	$product = Mage::getModel('catalog/product');
	$product->setStoreId($current_storeid);
	$product = $product->load($pro_id);
	if(($product->getId()) && ($allow_pro == "1")) {
		$this->item_available = "1";
		$this->url = $product->getProductUrl();
		}
	else
	{
		$this->item_available = "0";
		$this->url = "";
	}
	if(Mage::registry('current_product'))
	{
			if(Mage::registry('current_product')->getId()==$pro_id)
			{
			$this->active_class = ' active';
			}
	}
	}
	else if(($item->getType() == "5"))
	{ 	/* For Custom URL*/
			if($item->getUrlValue() != "") {
				if($item->getUseexternalurl() == "1"){
					$this->url = $item->getUrlValue();
				}else if($item->getUseexternalurl() == "0")
				{
				$this->url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).$item->getUrlValue();
				}
			
			$this->item_available = "1";
		}else
		{
			$this->url = "";
			$this->item_available = "0";
		}
		$urlString = Mage::helper('core/url')->getCurrentUrl();
		$currenturl = Mage::getSingleton('core/url')->parseUrl($urlString);
		$path = $currenturl->getPath();
		if (strpos($path,$item->getUrlValue()) !== false) {
		$this->active_class = ' active';	
		}
	}else if(($item->getType() == "6"))
	{
	/*For Alias Menu*/
	$this->url = "#;";
	$this->active_class = '';	
	}else if(($item->getType() == "7"))
	{
	/*For Alias Menu*/
	$this->url = "#;";
	$this->active_class = '';	
	}
	else if(($item->getType() == "account"))
	{
	/*For My Account  Menu*/
	$this->url = Mage::getUrl('customer/account');
	$this->active_class = '';	
	if(($module == 'customer') && ($controller == 'account') && ($action == 'index'))
	{
	$this->active_class = ' active';
	}
	}
	else if(($item->getType() == "cart"))
	{
	/*For My Cart  Menu*/
	$this->url = Mage::getUrl('checkout/cart');
	$this->active_class = '';	
	
	if(($module == 'checkout') && ($controller == 'cart') && ($action == 'index'))
	{
	$this->active_class = ' active';
	}
	
	}
	else if(($item->getType() == "wishlist"))
	{
	/*For My Wishlist  Menu*/
	$this->url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'wishlist/';
	$this->active_class = '';	
	
	if(($module == 'wishlist'))
	{
	$this->active_class = ' active';
	}
	}
	else if(($item->getType() == "checkout"))
	{
	/*For CheckOut Menu*/
	$this->url = Mage::helper('checkout/url')->getCheckoutUrl();
	$this->active_class = '';	
	
	if(($module == 'checkout') && ($controller == 'onepage') && ($action == 'index'))
	{
	$this->active_class = ' active';
	}
	}
	else if(($item->getType() == "login"))
	{
	/*For Login Menu*/
	$this->url = Mage::getUrl('customer/account/login');
	$this->active_class = '';	
	
	if(($module == 'customer') && ($controller == 'account') && ($action == 'login'))
	{
	$this->active_class = ' active';
	}
	if($menu_customer->isLoggedIn() == "1")
	{
		$this->item_available = "0";
	}else
	{
	$this->item_available = "1";
	}
	}
	else if(($item->getType() == "logout"))
	{
	/*For Logout Menu*/
	$this->url = Mage::getUrl('customer/account/logout');
	$this->active_class = '';	
	
	if(($module == 'customer') && ($controller == 'account') && ($action == 'logout'))
	{
	$this->active_class = ' active';
	}
	if($menu_customer->isLoggedIn() == "1")
	{
		$this->item_available = "1";
	}else
	{
	$this->item_available = "0";
	}
	}
	else if(($item->getType() == "register"))
	{
	/*For Register Menu*/
	$this->url = Mage::getUrl('customer/account/create');
	$this->active_class = '';	
	
	if($module == 'customer' && $controller == 'account' && $action == 'create')
	{
	$this->active_class = ' active';
	}
	if($menu_customer->isLoggedIn() == "1")
	{
		$this->item_available = "0";
	}else
	{
	$this->item_available = "1";
	}
	}
	else if(($item->getType() == "contact"))
	{
	/*For Contact Us Menu*/
	/*$module = Mage::app()->getFrontController()->getRequest()->getModuleName();*/
	$this->url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'contacts/';
		if($module == 'contacts')
		{
		$this->active_class = ' active';
		}	
	}
	if($item->getLabelTitle()!=""){
		$this->label_class = "haslbl";
	}else{
	$this->label_class = "";
	}
	$column_layout = trim($item->getSubcolumnlayout());

	if(($item->getAutosub() == "1") && ($item->getType() == "2") && (count($hasChild)=="0") && ($group_level > 0) )
	{
			$category_id = $item->getCategoryId();
			$childcatcount = Mage::getModel('navigationmenupro/category')->getChildCategoryCount($category_id);
			/* Here Make Custom Function to check the categories's sub child is active & set Include Yes in the menu then only it will display in the menu as sub cateogry.*/

		
			if($childcatcount > 0)
			{
			$this->has_child_element = 'parent';
			$this->has_smart_expand = '1';
			$this->item_autosub_cat = "1";
			}else
			{
			$this->has_child_element = '';
			$this->has_smart_expand = '';
			$this->item_autosub_cat = "0";
			}
	}
	
	if(($item->getType() == "3"))
	{
	/* Static block have no sub item so no need to add parent class in the static block li */
	$staticblock_active = Mage::getModel('cms/block')->setStoreId($current_storeid)->load($item->getStaticblockIdentifier())->getIsActive();
	if(($staticblock_active == "1") && ($group_level > 0) && ($column_layout != 'no-sub'))
	{
	$this->has_child_element = 'parent';
	$this->has_smart_expand = '1';
	}
	
	}else if(((count($hasChild)>0) || ($this->item_autosub_cat == "1")) && ($group_level > 0) && ($item->getType() != "3") && ($column_layout != 'no-sub')) {
	if($this->static_block_count > 0)
	{
	/* Check the Static block is active for the current store view then only add into the menu*/
		if(!empty($sub_static_block_status))
		{
		$this->has_child_element = 'parent';
		$this->has_smart_expand = '1';
		}
	}
	if(($count_submenu_item > 0) && !empty($subitemsavailable)) 
	
	{
	$this->has_child_element = 'parent';
	$this->has_smart_expand = '1';
	}
	
	
	}
	else
	{
	$this->has_child_element = '';
	$this->has_smart_expand = '';
	}
	if($item->getClassSubfix() != '')
	{
	$add_custom_class = $item->getClassSubfix();
	}
	if($item->getDescription() != '')
	{
	$this->link_title = trim($item->getDescription());
	}
	if($item->getSetrel() != '')
	{
	$this->link_relation = trim($item->getSetrel());
	}
	$target = $item->getTarget();
	if($target == "2")
	{
	$this->item_target = "target='_blank'";
	}
	/* Check item level with the group level Here Item menu level is greater then group level then that item is not allowed in the list.
	*/
	
	$item_menu_level = Mage::helper("navigationmenupro")->getlevel($item->getMenuId(),false);
	if($item_menu_level > $group_level)
	{
	$this->item_available = "0";
	}
	
	if($this->item_available != "0"){
	if($group_menutype != "list-item")
	{
	$text_align = $item->getTextAlign();
	if($text_align == 'left')
	{
	$text_align = "aLeft";
	}else if($text_align == 'right'){
	$text_align = "aRight";
	}else if($text_align == 'full-width')
	{
	$text_align = $item->getTextAlign();
	}
	$this->column_layout_align = $column_layout.' '.$text_align;
	}
	
	
	
	/*
	Here Check Column Layout which is greater then the one column and menu type is
	mega-menu then add the mega menu class in the root li.	*/
	if(($column_layout != 'no-sub') && ($column_layout != 'column-1') && ($group_menutype == "mega-menu"))
	{
	$add_custom_class .= ' megamenu ';
	}
	if(($len == 1) && ($i == 0)){
	$html .= '<li class="Level'.$item_menu_level.' first last '.$this->has_child_element.' '.$add_custom_class.' '.$this->column_layout_align.$this->static_blcok_class.'">';
	}else if (($i == 0) && ($len != 1)) {
		$html .= '<li class="Level'.$item_menu_level.' first '.$this->has_child_element.' '.$add_custom_class.' '.$this->column_layout_align.$this->static_blcok_class.'">';
	}else if ($i == $len - 1) {
		$html .= '<li class="Level'.$item_menu_level.' last '.$this->has_child_element.' '.$add_custom_class.' '.$this->column_layout_align.$this->static_blcok_class.'">';
    }else 
	{
	$html .= '<li class="Level'.$item_menu_level.' '.$this->has_child_element.' '.$add_custom_class.' '.$this->column_layout_align.$this->static_blcok_class.'">';
	}
	
	/* Set Menu Item Image base on the menu type if menu type is 
	category then use thumbnail & base image otherwise use custom uploaded images.*/
	
	if((($item->getShowCategoryImage() != 'none')||($item->getShowCustomCategoryImage() == '1')) && ($item->getType() == "2")) 
	{
		if($item->getShowCustomCategoryImage() == '1')
		{	
			$image_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'navigationmenupro/image/'.$item->getImage();
			$image_tag = "<span class=img><img src='".$image_url."' /></span>";

		}else if($item->getShowCategoryImage() == 'thumbnail_image')
		{	
			$cat_id = $item->getCategoryId();
			$category_image = Mage::getModel('catalog/category')->load($cat_id);
			if($category_image->getThumbnail() != '')
			{
			$image_url = Mage::getBaseUrl('media').'catalog/category/'.$category->getThumbnail();
			$image_tag = "<span class=img><img src='".$image_url."' /></span>";
			}
		}else if($item->getShowCategoryImage() == 'main_image')
		{
		
		$cat_id = $item->getCategoryId();
		$category_image = Mage::getModel('catalog/category')->load($cat_id);
		if($category_image->getImageUrl() != ''){
			$image_url = $category_image->getImageUrl();
			$image_tag = "<span class=img><img src='".$image_url."' /></span>";
		}
		}
		
	}
	else 
	{
	if(($item->getImageStatus() == '1') && ($item->getImage() != '') && ($item->getType() != "2"))
	{
	$image_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'navigationmenupro/image/'.$item->getImage();
	$image_tag = "<span class=img><img src='".$image_url."'  /></span>";
	}
	}
	
	if(($item->getType() == "3"))
	{
		$active = Mage::getModel('cms/block')->setStoreId($current_storeid)->load($item->getStaticblockIdentifier())->getIsActive();
		if (($active == 1) && ($group_level > 0) && ($column_layout != 'no-sub') ){
		/* Here If the Static block item is set as Root then we display the Menu item li A link of the static block.*/
		$html .= '<a rel="'.$this->link_relation.'" class="Level'.$item_menu_level.' '.$this->label_class.'" title="'.$this->link_title.'" href="'.$this->url.'"'.$this->item_target.'>';
		/* For Static block Add Image Tag In between the A link in the Li*/
		
		if(($item->getImageStatus() == '1') && ($item->getImage() != ''))
			{
			$html .= $image_tag;
			}
			/* Item Label Code Start*/
			$html .= $item->getTitle();
			if($item->getLabelTitle()!=""){
			$label = '<sup class="menulbl" style="background-color:'.$item->getLabelBgColor().'; color:'.$item->getLabelColor().'; font-size:'.$item->getLabelHeight().'px; line-height:'.$item->getLabelHeight().'px;">'.$item->getLabelTitle().'</sup>';
			$html .= $label;
			}
			/* Item Label Code completed*/
			//$html .= $item->getTitle().'</a>';
			
			if(($group_menutype != "list-item") && ($this->has_smart_expand == "1")){
				$html .= '<span class="arw plush" title="Click to show/hide children"></span>';
			}
			$html .= '</a>';
			
			/* Here If Group Level Is Greater then Zero then only Static block content Add into the menu item.*/
			if(($group_level > 0) && ($group_level > 0) && ($column_layout != 'no-sub')){
			$html .= '<ul class="Level0 subMenu"><li class="Level1 first last">';	
			$html .= '<div class="111'.$this->static_blcok_class.'">';
		$html .= Mage::app()->getLayout()->createBlock('cms/block')->setBlockId($item->getStaticblockIdentifier())->toHtml();
		$html .= '</div>';
		$html .='</li></ul>';
		
			}
		
		
		}
	
	}else
	{
	$html .= '<a rel="'.$this->link_relation.'" class="Level'.$item_menu_level.' '.$this->label_class.'" title="'.$this->link_title.'" href="'.$this->url.'"'.$this->item_target.'>';
	/* Add Image Tag In between the A link in the Li*/
	if(
	(($item->getImageStatus() == '1') && ($item->getImage() != '')) || 
	(($item->getShowCategoryImage() != 'none')||($item->getShowCustomCategoryImage() == '1')) && 
	($image_url != ''))
	{
	$html .= $image_tag;
	}
	$image_tag = '';
	$html .= $item->getTitle();
	/* Item Label Code Start*/
			if($item->getLabelTitle()!=""){
			$label = '<sup class="menulbl" style="background-color:'.$item->getLabelBgColor().'; color:'.$item->getLabelColor().'; font-size:'.$item->getLabelHeight().'px; line-height:'.$item->getLabelHeight().'px;">'.$item->getLabelTitle().'</sup>';
			$html .= $label;
			}
			/* Item Label Code completed*/
	if(($group_menutype != "list-item") && ($this->has_smart_expand == "1")){
		$html .= '<span class="arw plush" title="Click to show/hide children"></span>';
	}
	
	$html .= '</a>';
	
	
	}
	/* Add + & - Sign for the Smart-Expand Menu Type in the Li item for all which has sub item.
	Here when Parent Item is the category with the Auto-sub then it will also add the plus & minus sign in the ul & li.
	*/
	
	
	
	}
	 $i++;
	
	/* Use TO Get The Sub Category If set Auto Sub On when the menu type is category.
	Here Check the Item Sub Column Layout If it set as no-sub then Auto Sub will not displayed.
	If Menu Item Level is Set Only Root then It will not display Sub Category In the List.
	group_level.
	Here item_autosub_cat is check the Category has sub item or not.
	*/
	if($this->item_available != "0"){
	if(($item->getAutosub() == "1") && ($item->getType() == "2") && (count($hasChild)=="0") && ($group_level > 0) && ($item_menu_level <= $group_level) && ($this->item_autosub_cat == "1") && ($column_layout != 'no-sub'))
	{
	$this->my_cat_image_type = $item->getShowCategoryImage();
	$cat_image_type = $item->getShowCategoryImage();
	$show_hide_cat_image = $item->getAutosubimage();
	$item_parentId = $item->getParent_Id();
	$html .= $this->getCategoriesAutoSub($item->getCategoryId(),true,$item_menu_level,$group_level,$group_menutype,$cat_image_type,$show_hide_cat_image,$item_parentId);
	}
	/* Here We restrict the Static block's subitem in the front so we can not display child of the static block item.
	Check the Menu Level with the Gruop Level.
	Here Our Item_menu_level start with 0 so we add (+1) in the Item_menuevel
	so set the correct menu item in the list
	Here Check the Sub Column Layout if it set the no-sub then child menu item not added into the list
	
	
	*/
	if((count($hasChild)>0) && ($item->getType() != "3") && ($item_menu_level <= $group_level) && ($item->getSubcolumnlayout() != "no-sub") && ($group_level != "0") )
	{
	
	if(!empty($subitemsavailable)){
	$html .= $this->getChildHtml($item->getMenuId(),true);
	}

	}
	
	}
	
	if($this->item_available != "0"){
	$html .= '</li>';
	}
	
	}
		
return $html;
}
function getChildCount($parent_menu_id){
$current_storeid = Mage::app()->getStore()->getStoreId();
$menu_customer = Mage::getModel('navigationmenupro/customer');
$permission = $menu_customer->getUserPermission();
$allChildWithoutStaticblock = Mage::getModel('navigationmenupro/menucreator')->getCollection()
				->setOrder("position","asc")
				->addFieldToFilter('parent_id',$parent_menu_id)
				->addFieldToFilter('type', array('neq' => '3'))
				->addFieldToFilter('status',"1")
				->addFieldToFilter('storeids', array(array('finset' => $current_storeid)))
				->addFieldToFilter('permission', array('in' => array($permission)));
				return count($allChildWithoutStaticblock);	
}

function getChildStaticblockStatus($parent_menu_id){
$this->static_block_status = array();
$this->static_block_count = '';
$current_storeid = Mage::app()->getStore()->getStoreId();
$menu_customer = Mage::getModel('navigationmenupro/customer');
$permission = $menu_customer->getUserPermission();
$allChildStaticblock = Mage::getModel('navigationmenupro/menucreator')->getCollection()
				->setOrder("position","asc")
	
                ->addFieldToFilter('parent_id',$parent_menu_id)
	
				->addFieldToFilter('type',"3")
	
				->addFieldToFilter('status',"1")
	
				->addFieldToFilter('storeids', array(array('finset' => $current_storeid)))
	
				->addFieldToFilter('permission', array('in' => array($permission)));
$this->static_block_count = count($allChildStaticblock);	
foreach($allChildStaticblock as $item){
	if(($item->getType() == "3"))
	{
	if($item->getStaticblockIdentifier() != '')
	{
	
	$active = Mage::getModel('cms/block')->setStoreId($current_storeid)->load($item->getStaticblockIdentifier())->getIsActive();
		if ($active == 1){
		$this->static_block_status[$item->getStaticblockIdentifier()] = "1";
		}
	}
	}
}
return $this->static_block_status;
}
function getChildHtml($parentId, $isChild){
$current_storeid = Mage::app()->getStore()->getStoreId();
$menu_customer = Mage::getModel('navigationmenupro/customer');
$permission = $menu_customer->getUserPermission();
	
$allChild = Mage::getModel('navigationmenupro/menucreator')->getCollection()
				->setOrder("position","asc")
				->addFieldToFilter('parent_id',$parentId)
				/*Only Enabled Item will be list in the menu item*/
				->addFieldToFilter('status',"1")
				/*Filter Collection By Store Id*/
				->addFieldToFilter('storeids', array(array('finset' => $current_storeid)))
					/*Filter Collection By User Permission */
				->addFieldToFilter('permission', array('in' => array($permission)));
	$action = Mage::app()->getFrontController()->getRequest()->getActionName();
	$module = Mage::app()->getFrontController()->getRequest()->getModuleName();
	$controller = Mage::app()->getFrontController()->getRequest()->getControllerName();
	
	$Parent_menu = Mage::getModel('navigationmenupro/menucreator')->load($parentId);
	/* Get Group Id From the Current Menu Item*/
	$group_id = $Parent_menu->getGroupId();
	$group_details = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	$group_level = $group_details->getLevel();
	$group_menutype = $group_details->getMenutype();
	$menu_level = Mage::helper("navigationmenupro")->getlevel($parentId,false);
	$class = ($isChild) ? " subMenu" : " ";
   
	/*
	Add Div in the Group Items */
	if($Parent_menu->getType() == "7"){
//	$html .= "<div class='column-group'>";
	}
	/* if($Parent_menu->getType() != "7"){
	$html .= '<ul class="Level'.$menu_level.$class.' childmenu">';
	} */
	$html = isset($html) ? $html : '';
	$html .= '<ul class="Level'.$menu_level.$class.' ">';
	
	
	$j = 0;
	$len_child = count($allChild);
	
	foreach($allChild as $item)
    {
	$this->item_available = '';
	$this->label_class  = '';
	$this->item_autosub_cat = '';
	$this->active_class = '';
	$this->has_child_element = '';
	$this->has_smart_expand = '';
	$this->column_layout_align = '';
	$this->static_blcok_class = '';
	$this->url = '';
	$image_tag = '';
	$image_url = '';
	$this->link_title = '';
	$this->item_target = '';
	$child_status = '';
	$add_custom_class = '';
	$sub_static_block_status = $this->getChildStaticblockStatus($item->getMenuId());
	$count_submenu_item = $this->getChildCount($item->getMenuId());
	$subitemsavailable = $this->subitemsavailable($item->getMenuId());
	if($item->getLabelTitle()!=""){
		$this->label_class = "haslbl";
	}else{
	$this->label_class = "";
	}
	$column_layout = trim($item->getSubcolumnlayout());
	if(($item->getType() == "1"))
	{
	/* Check CMS Page is Active & From the Current Store Visible Or not*/
	$page_active_check = Mage::getModel('cms/page')->setStoreId($current_storeid)->load($item->getCmspageIdentifier())->getIsActive();
	if($page_active_check == "1")
	{
	 /* If CMS page is home page then no need to add the page Identifier.*/
	  if($item->getCmspageIdentifier() != 'home')
	  {
	  $this->url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).$item->getCmspageIdentifier().'/'; 
	  }else
	  {
	  $this->url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
	  }
	$this->item_available = "1";
	}else
	{
	$this->url = '';
	$this->item_available = "0";
	}
	if(Mage::app()->getFrontController()->getRequest()->getRouteName() == 'cms')
	{
		if(Mage::getSingleton('cms/page')->getIdentifier() == $item->getCmspageIdentifier())
		{
			$this->active_class = ' active';
		}
	
	}
	/* For Category Pages*/
	}else if(($item->getType() == "2"))
	{
	$cat_id = $item->getCategoryId();
	$allow_cat = Mage::getModel('navigationmenupro/category')->checkCagegoryAvailable($cat_id);
	$category = Mage::getModel('catalog/category');
	$category->setStoreId($current_storeid);
	$category = $category->load($cat_id);
	$rootCategoryId = Mage::app()->getStore()->getRootCategoryId();
	if(($category->getId()) && ($allow_cat == "1")) {
			
			if($category->getLevel() != '1')
				{
				$this->url = $category->getUrl($category);
				}else
				{
				$this->url = "#";
				}
			$this->item_available = "1";
		}else
		{
			$this->url = "";
			$this->item_available = "0";
		}
		if(Mage::registry('current_category'))
		{
		if(Mage::registry('current_category')->getId()==$cat_id)
		{
		$this->active_class = ' active';
		}
		}
		
	}
		/* For Static Blocks*/
	else if(($item->getType() == "3"))
	{
	if($item->getStaticblockIdentifier() != '')
	{
	/* Static block is active for the current store then add into the menu item*/
	$active = Mage::getModel('cms/block')->setStoreId($current_storeid)->load($item->getStaticblockIdentifier())->getIsActive();
		if ($active == 1){
		$this->item_available = "1";
		$this->static_blcok_class = ' cmsbk';
		}else
		{
		$this->item_available = "0";
		$this->static_blcok_class = '';
		}
	}
	}
	/* For Product Pages*/
	else if(($item->getType() == "4"))
	{ 	
	$pro_id = $item->getProductId();
	$product = Mage::getModel('catalog/product');
	$product->setStoreId($current_storeid);
	$product = $product->load($pro_id);
	$allow_pro = Mage::getModel('navigationmenupro/product')->checkProductavailable($pro_id);
	if(($product->getId()) && ($allow_pro == "1")) {
			$this->url = $product->getProductUrl();
			$this->item_available = "1";
		}else
		{
			$this->url = "";
			$this->item_available = "0";
		}
		if(Mage::registry('current_product'))
		{
		if(Mage::registry('current_product')->getId()==$pro_id)
		{
		$this->active_class = ' active';
		}
		}
	}
	else if(($item->getType() == "5"))
	{ 	/* For Custom URL*/
		if($item->getUrlValue() != "") {
				if($item->getUseexternalurl() == "1"){
					$this->url = $item->getUrlValue();
				}else if($item->getUseexternalurl() == "0")
				{
				$this->url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).$item->getUrlValue();
				}
			$this->item_available = "1";
			/*Here Target Is custom URL SO We set to
			 Open in the New Tab*/
		}else
		{
			$this->url = "";
			$this->item_available = "0";
		}
		$urlString = Mage::helper('core/url')->getCurrentUrl();
		$currenturl = Mage::getSingleton('core/url')->parseUrl($urlString);
		$path = $currenturl->getPath();
		if (strpos($path,$item->getUrlValue()) !== false) {
		$this->active_class = ' active';	
		}
	
	}else if(($item->getType() == "6"))
	{
	/*For Alias Menu*/
	$this->url = "#;";
	$this->active_class = '';	
	}else if(($item->getType() == "7"))
	{
	/*For Alias Menu*/
	$this->url = "#;";
	$this->active_class = '';	
	}
	else if(($item->getType() == "account"))
	{
	/*For My Account  Menu*/
	$this->url = Mage::getUrl('customer/account');
	$this->active_class = '';	
	
	if(($module == 'customer') && ($controller == 'account') && ($action == 'index'))
	{
	$this->active_class = ' active';
	}
	}else if(($item->getType() == "cart"))
	{
	/*For My Cart  Menu*/
	$this->url = Mage::getUrl('checkout/cart');
	$this->active_class = '';	
	
	if(($module == 'checkout') && ($controller == 'cart') && ($action == 'index'))
	{
	$this->active_class = ' active';
	}
	
	}
	else if(($item->getType() == "wishlist"))
	{
	/*For My Wishlist  Menu*/
	$this->url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'wishlist/';
	$this->active_class = '';	
	
	if(($module == 'wishlist'))
	{
	$this->active_class = ' active';
	}
	}
	else if(($item->getType() == "checkout"))
	{
	/*For CheckOut Menu*/
	$this->url = Mage::helper('checkout/url')->getCheckoutUrl();
	$this->active_class = '';	
	
	if(($module == 'checkout') && ($controller == 'onepage') && ($action == 'index'))
	{
	$this->active_class = ' active';
	}
	}
	else if(($item->getType() == "login"))
	{
	/*For Login Menu*/
	$this->url = Mage::getUrl('customer/account/login');
	$this->active_class = '';	
	
	 if(($module == 'customer') && ($controller == 'account') && ($action == 'login'))
	{
	$this->active_class = ' active';
	}
	if($menu_customer->isLoggedIn() == "1")
	{
		$this->item_available = "0";
	}else
	{
	$this->item_available = "1";
	}
	}
	else if(($item->getType() == "logout"))
	{
	/*For Logout Menu*/
	$this->url = Mage::getUrl('customer/account/logout');
	$this->active_class = '';	
	
	if(($module == 'customer') && ($controller == 'account') && ($action == 'logout'))
	{
	$this->active_class = ' active';
	}
	if($menu_customer->isLoggedIn() == "1")
	{
		$this->item_available = "1";
	}else
	{
	$this->item_available = "0";
	}
	}
	else if(($item->getType() == "register"))
	{
	/*For Register Menu*/
	$this->url = Mage::getUrl('customer/account/create');
	$this->active_class = '';	
	
	if($module == 'customer' && $controller == 'account' && $action == 'create')
	{
	$this->active_class = ' active';
	}
	if($menu_customer->isLoggedIn() == "1")
	{
		$this->item_available = "0";
	}else
	{
	$this->item_available = "1";
	}
	}
	else if(($item->getType() == "contact"))
	{
	/*For Contact Us Menu*/
	
	$this->url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'contacts/';
		if($module == 'contacts')
		{
		$this->active_class = ' active';
		}	
	}
	
	$hasChild = $this->getChildMenuCollection($item->getMenuId());
	$item_menu_level = Mage::helper("navigationmenupro")->getlevel($item->getMenuId(),false);
	
	
	if(($item->getAutosub() == "1") && ($item->getType() == "2") && (count($hasChild)=="0") && ($item_menu_level <= $group_level))
	{
			$category_id = $item->getCategoryId();
			$childcatcount = Mage::getModel('navigationmenupro/category')->getChildCategoryCount($category_id);
			/* Here Make Custom Function to check the categories's sub child is active & set Include Yes in the menu then only it will display in the menu as sub cateogry.*/
		
			if($childcatcount > 0)
			{
			$this->has_child_element = 'parent';
			$this->has_smart_expand = '1';
			$this->item_autosub_cat = "1";
			}else
			{
			$this->has_child_element = '';
			$this->has_smart_expand = '';
			$this->item_autosub_cat = "0";
			}
	}
	if(($item->getType() == "3"))
	{
	/* Static block have no sub item so no need to add parent class in the static block li */
	$staticblock_active = Mage::getModel('cms/block')->setStoreId($current_storeid)->load($item->getStaticblockIdentifier())->getIsActive();
	if(($staticblock_active == "1") && ($group_level > $item_menu_level) && ($column_layout != 'no-sub'))
	{
	$this->has_child_element = '';
	$this->has_smart_expand = '';
	}else
	{
	$this->has_child_element = '';
	$this->has_smart_expand = '';
	}
	}else if(((count($hasChild)>0) || ($this->item_autosub_cat == "1")) && ($item->getType() != "3") && ($item_menu_level < $group_level) && ($column_layout != 'no-sub')) {
	if($this->static_block_count > 0)
	{
	/* Check the Static block is active for the current store view then only add into the menu*/
		if(!empty($sub_static_block_status))
		{
		$this->has_child_element = 'parent';
		$this->has_smart_expand = '1';
		}
		
	}
	if(($count_submenu_item > 0) && !empty($subitemsavailable)) 
	{
		$this->has_child_element = 'parent';
		$this->has_smart_expand = '1';
	}
	
	}
	
	else
	{
	$this->has_child_element = '';
	$this->has_smart_expand = '';
	}
	
	if($item->getClassSubfix() != '')
	{
	$add_custom_class = $item->getClassSubfix();
	}
	if($item->getDescription() != '')
	{
	$this->link_title = trim($item->getDescription());
	}
	if($item->getSetrel() != '')
	{
	$this->link_relation = trim($item->getSetrel());
	}
	$target = $item->getTarget();
	if($target == "2")
	{
	$this->item_target = "target='_blank'";
	}
	
	/* Check item level with the group level Here Item menu level is greater then group level then that item is not allowed in the list.
	
	*/
	if($item_menu_level > $group_level)
	{
	$this->item_available = "0";
	}
	
	if($this->item_available != "0"){
	 if($group_menutype != "list-item")
	 {
		$text_align = $item->getTextAlign();
		$column_layout = trim($item->getSubcolumnlayout());
		if($text_align == 'left')
		{
		$text_align = "aLeft";
		}else if($text_align == 'right'){
		$text_align = "aRight";
		}else if($text_align == 'full-width'){
		$text_align = $item->getTextAlign();
		}	
		$this->column_layout_align = $column_layout.' '.$text_align;	
	 } 
	 
	if(($item->getType() != "7")){
	 
	if(($len_child == 1) && ($j == 0)){
		$html .= '<li class="Level'.$item_menu_level.' first last '.$this->has_child_element.' '.$add_custom_class.' '.$this->column_layout_align.$this->static_blcok_class.'" >';
	}else if (($j == 0) && ($len_child != 1)) {
		$html .= '<li class="Level'.$item_menu_level.' first '.$this->has_child_element.' '.$add_custom_class.' '.$this->column_layout_align.$this->static_blcok_class.'" >';
	}else if ($j == $len_child-1) {
		$html .= '<li class="Level'.$item_menu_level.' last '.$this->has_child_element.' '.$add_custom_class.' '.$this->column_layout_align.$this->static_blcok_class.'" >';
    }else
	{
	$html .= '<li class="Level'.$item_menu_level.' '.$this->has_child_element.' '.$add_custom_class.' '.$this->column_layout_align.$this->static_blcok_class.'" >';
	}
	}else if($item->getType() == "7")
	{
	$html .= '<li class="Level'.$item_menu_level.' '.$this->has_child_element.' '.$add_custom_class.' '.$this->column_layout_align.' hideTitle" >';
	}
	
	
	/*
	Set Menu Item Image in the li 
	*/
	if((($item->getShowCategoryImage() != 'none')||($item->getShowCustomCategoryImage() == '1')) && ($item->getType() == "2"))
	{
		if($item->getShowCustomCategoryImage() == '1')
		{	
			$image_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'navigationmenupro/image/'.$item->getImage();
			$image_tag = "<span class=img><img src='".$image_url."' /></span>";

		}else if($item->getShowCategoryImage() == 'thumbnail_image')
		{
		$cat_id = $item->getCategoryId();
		
		$category_image = Mage::getModel('catalog/category')->load($cat_id);
			if($category_image->getThumbnail() != ''){
				$image_url = Mage::getBaseUrl('media').'catalog/category/'.$category->getThumbnail();
				$image_tag = "<span class=img><img src='".$image_url."' /></span>";
			}
		
		}else if($item->getShowCategoryImage() == 'main_image')
		{
		$cat_id = $item->getCategoryId();
		$category_image = Mage::getModel('catalog/category')->load($cat_id);
		$image_url = $category_image->getImageUrl();
			if($image_url != ''){
			$image_tag = "<span class=img><img src='".$image_url."' /></span>";
			}
		
		}
		
	}
	else 
	{
	if(($item->getImageStatus() == '1') && ($item->getImage() != '') && ($item->getType() != "2") && ($item->getType() != "7"))
	{
	$image_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'navigationmenupro/image/'.$item->getImage();
	$image_tag = "<span class=img><img src='".$image_url."'  /></span>";
	}
	}
	/* Here For the Static Block We Remove the Static BLock Item Content From the Li and direct display the static block content in that li insted of item content.*/
	if(($item->getType() == "3"))
	{
	$active = Mage::getModel('cms/block')->setStoreId($current_storeid)->load($item->getStaticblockIdentifier())->getIsActive();
	
		if (($active == 1) && ($item_menu_level <= $group_level) && ($column_layout != 'no-sub')){
		/* Add Image Tag In between the A link in the Li*/
		if($item->getTitleShowHide() == 'show'){
			$html .= '<a rel="'.$this->link_relation.'" class="Level'.$item_menu_level.' '.$this->has_child_element.$child_status.' '.$this->label_class.'" title="'.$this->link_title.'" href="'.$this->url.'"'.$this->item_target.'>';
			if(($item->getImageStatus() == '1') && ($item->getImage() != ''))
			{
			$html .= $image_tag;
			}
			$html .= $item->getTitle();
			/* Item Label Code Start*/
			if($item->getLabelTitle()!=""){
			$label = '<sup class="menulbl" style="background-color:'.$item->getLabelBgColor().'; color:'.$item->getLabelColor().'; font-size:'.$item->getLabelHeight().'px; line-height:'.$item->getLabelHeight().'px;">'.$item->getLabelTitle().'</sup>';
			$html .= $label;
			}
			/* Item Label Code completed*/
			if(($group_menutype != "list-item") && ($this->has_smart_expand == "1")){
				$html .= '<span class="arw plush" title="Click to show/hide children"></span>';
			}
			$html .= '</a>';

		}
		else if($item->getTitleShowHide() == 'hide'){
			if(($item->getImageStatus() == '1') && ($item->getImage() != ''))
			{
			$html .= $image_tag;
			}
			
		}
		
		/* if(($group_menutype != "list-item") && ($this->has_smart_expand == "1"))
		{
		$html .= '<span class="arw plush" title="Click to show/hide children"></span>';
		} */
			$html .= '<span class="arw plush" title="Click to show/hide children"></span><div class="222'.$this->static_blcok_class.'">';
			$html .= Mage::app()->getLayout()->createBlock('cms/block')->setBlockId($item->getStaticblockIdentifier())->toHtml();
			$html .= '</div>';
	}
	}else if(($item->getType() == "6"))
	{
		if (($item_menu_level <= $group_level) && ($column_layout != 'no-sub')){
		/* Add Image Tag In between the A link in the Li*/
		$html .= '<a rel="'.$this->link_relation.'" class="Level'.$item_menu_level.' '.$this->has_child_element.$child_status.' '.$this->label_class.'" title="'.$this->link_title.'" href="'.$this->url.'"'.$this->item_target.'>';
		if(($item->getImageStatus() == '1') && ($item->getImage() != ''))
		{
		$html .= $image_tag;
		}
		$html .= $item->getTitle();
		/* Item Label Code Start*/
			if($item->getLabelTitle()!=""){
			$label = '<sup class="menulbl" style="background-color:'.$item->getLabelBgColor().'; color:'.$item->getLabelColor().'; font-size:'.$item->getLabelHeight().'px; line-height:'.$item->getLabelHeight().'px;">'.$item->getLabelTitle().'</sup>';
			$html .= $label;
			}
			/* Item Label Code completed*/
			if(($group_menutype != "list-item") && ($this->has_smart_expand == "1")){
				$html .= '<span class="arw plush" title="Click to show/hide children"></span>';
			}
		$html .= '</a>';
		
			
	}
	} else {
	$html .= '<a rel="'.$this->link_relation.' '.$this->label_class.'" class="Level'.$item_menu_level.' '.$this->has_child_element.$child_status.'" title="'.$this->link_title.'" href="'.$this->url.'"'.$this->item_target.'>';
	/* Add Image Tag In between the A link in the Li*/
	
	if((($item->getImageStatus() == '1') && ($item->getImage() != '') ) || ((($item->getShowCategoryImage() != 'none')||($item->getShowCustomCategoryImage() == '1')) && ($image_url != '')))
	{
	$html .= $image_tag;
	}
	$html .= $item->getTitle();
	/* Item Label Code Start*/
			if($item->getLabelTitle()!=""){
			$label = '<sup class="menulbl" style="background-color:'.$item->getLabelBgColor().'; color:'.$item->getLabelColor().'; font-size:'.$item->getLabelHeight().'px; line-height:'.$item->getLabelHeight().'px;">'.$item->getLabelTitle().'</sup>';
			$html .= $label;
			}
			/* Item Label Code completed*/
		if(($group_menutype != "list-item") && ($this->has_smart_expand == "1")){
			$html .= '<span class="arw plush" title="Click to show/hide children"></span>';
		}
	$html .= '</a>';
	
	}
	
	}
	$j++;
	/* Use TO Get The Sub Category If set Autoi Sub On when the menu type is category.
	Here Check the Item Sub Column Layout If it set as no-sub then Auti Sub will not displayed.
	If Menu Item Level is Set Only Root then It will not display Sub Category In the List.
	group_level.
	Here item_autosub_cat is check the Category has sub item or not.
	*/
	
	if($this->item_available != "0"){
	if(($item->getAutosub() == "1") && ($item->getType() == "2") && (count($hasChild)=="0") && ($item_menu_level < $group_level) && ($this->item_autosub_cat == "1")&& ($column_layout != 'no-sub'))
	{
	$cat_image_type = $item->getShowCategoryImage();
	$show_hide_cat_image = $item->getAutosubimage();
	$item_parentId = $item->getParent_Id();
	$html .= $this->getCategoriesAutoSub($item->getCategoryId(),true,$item_menu_level,$group_level,$group_menutype,$cat_image_type,$show_hide_cat_image,$item_parentId);
	}
	/* Here We restrict the Static block's subitem in the front so we can not display child of the static block item.
	Check the Menu Level with the Gruop Level.
	*/
	
	if((count($hasChild)>0) && ($item->getType() != "3") && ($item_menu_level < $group_level) && ($item->getSubcolumnlayout() != "no-sub"))
	{
	$child_menu_item_count = 0;
	
	if(!empty($subitemsavailable)){
	$html .= $this->getChildHtml($item->getMenuId(),true);
	}
	}
	//if($item->getType() != "7"){
	if(($item->getType() != "7")){
	// $html .= '</li>';
	 } 
	 $html .= '</li>';
	 
	
	 
	}
	/* Add Static Block Content At the End of all it's child Element */
	
	}
	
	$html .= '</ul>';
	
	
	return $html;
}
	public function getMenuGroupdetails()
	{		$group_menu = array();
			$menugroup_grid = $this->getMenuGroup();
			
			foreach ($menugroup_grid as $group) {
				$group_details = Mage::getModel('navigationmenupro/menucreatorgroup')->load($group->getGroupId());
				$group_id = $group->getGroupId();
				$group_menu[$group_id] = $group_details->getTitle();
			}
			return $group_menu;
	}
	
	function getCategoriesAutoSub($parentId, $isChild,$item_menu_level,$group_level,$group_menutype,$cat_image_type,$show_hide_cat_image,$item_parentId){
	//echo 'show_hide_cat_image  ::'.$show_hide_cat_image;echo '<br/>';
	
	/* Load Category Base On the Current Store*/
	$current_storeid = Mage::app()->getStore()->getStoreId();
	$rootCategoryId = Mage::app()->getStore()->getRootCategoryId();
	$rootpath = Mage::getModel('catalog/category')
                    ->setStoreId($current_storeid)
                    ->load($rootCategoryId)
                    ->getPath();
	$allCats = Mage::getModel('catalog/category')->setStoreId($current_storeid)
                    ->getCollection()
                    ->addAttributeToSelect('*')
					->addAttributeToFilter('include_in_menu', array('eq' => 1))
					->addAttributeToFilter('is_active', array('eq' => 1))					
					->addAttributeToFilter('parent_id',array('eq' => $parentId))
                    ->addAttributeToFilter('path', array("like"=>$rootpath."/"."%"))
					 ->addAttributeToSort('position', 'asc'); 
    
	$class = ($isChild) ? " subMenu" : " ";
	$html = isset($html) ? $html : '';
    $html .= '<ul class="Level'.$item_menu_level.$class.'">'; 
	
	$item_menu_level = $item_menu_level+1;
    $cat_count = count($allCats);
	$k=0;
	
	
	foreach($allCats as $category)
    {	
	$countChildProduct = $category->getProductCount();
	/*if($group_menutype == 'smart-expand'){
		Zend_Debug::dump($countChildProduct);
	}*/
	
	// if($countChildProduct <= 0 && $group_menutype == 'smart-expand') continue;
	if($countChildProduct <= 0) continue;
	$childcatcount = Mage::getModel('navigationmenupro/category')->getChildCategoryCount($category->getId());
		$cat_level = $category->getLevel()-2;
		$subcats = $category->getChildren();
		/*Check Group Level With the Menu Item Level For the 
		Auto SUb Category
		*/
		if(($childcatcount > 0) && ($subcats != '') && ($item_menu_level < $group_level)) {
		//$this->has_child_element = ' has-children';
		/*if(($subcats != '')) {*/
		$this->autosub_has_child_element = ' parent';
		$this->autosub_has_smart_expand = '1';
		}
		
		/*Current Page is Category Page Or not For the Auto Sub Category Set Active*/
		if (Mage::registry('current_category'))
		{
			if((Mage::registry('current_category')->getId()) == $category->getId()):
			$this->active_class = ' active';
			
			else:
			$this->active_class = '';
			
			endif;
		}else
		{
		
		$this->active_class = '';
		}
		/* Use to Set Auto Sub Category For the mega menu.*/
		if($cat_level =="1")
		{
			$custom_layout = " column-1";
			
		}else
		{
			$custom_layout = "";
		}
		if($item_menu_level <= $group_level){
		if(($cat_count == 1) && ($k == 0)){
		$html .= '<li class="Level'.$item_menu_level.' '.$this->autosub_has_child_element.' first last'.$custom_layout.'">';
	}else if (($k == 0) && ($cat_count != 1)) {
		$html .= '<li class="Level'.$item_menu_level.' '.$this->autosub_has_child_element.' first'.$custom_layout.'">';
	}else if ($k == $cat_count-1) {
		$html .= '<li class="Level'.$item_menu_level.' '.$this->autosub_has_child_element.' last'.$custom_layout.'">';
    }else
	{
	$html .= '<li class="Level'.$item_menu_level.' '.$this->autosub_has_child_element.''.$custom_layout.' ">';
	}
	
	if(($group_menutype != "list-item") && ($this->autosub_has_smart_expand == "1"))
	{
	$html .= '<a href='.$category->getUrl($category).' class="Level'.$item_menu_level.'" title="'.$category->getName().'">';
	if($show_hide_cat_image == "1")
	{
		if($cat_image_type != 'none') 
		{
		if($cat_image_type == 'thumbnail_image')
		{	
			if($category->getThumbnail() != '')
			{
			$image_url = Mage::getBaseUrl('media').'catalog/category/'.$category->getThumbnail();
			$html .= "<span class=img><img src='".$image_url."' /></span>";
			}
		}else if($cat_image_type == 'main_image')
		{
		if($category->getImageUrl() != ''){
			$image_url = $category->getImageUrl();
			$html .= "<span class=img><img src='".$image_url."' /></span>";
		}
		}
		
	}
	}
	$html .= '<span class="arw plush" title="Click to show/hide children"></span>';
	$html .= $category->getName().'</a>';
	}else
	{
	$html .= '<a href='.$category->getUrl($category).' class="Level'.$item_menu_level.'" title="'.$category->getName().'">';
	if($show_hide_cat_image == "1")
	{
		if($cat_image_type != 'none') 
		{
		if($cat_image_type == 'thumbnail_image')
		{	
			if($category->getThumbnail() != '')
			{
			$image_url = Mage::getBaseUrl('media').'catalog/category/'.$category->getThumbnail();
			$html .= "<span class=img><img src='".$image_url."' /></span>";
			}
		}else if($cat_image_type == 'main_image')
		{
		if($category->getImageUrl() != ''){
			$image_url = $category->getImageUrl();
			$html .= "<span class=img><img src='".$image_url."' /></span>";
		}
		}
		
	}
	}
	$html .= $category->getName().'</a>';
	}
	
	
	
	}	$k++;
	
		$this->autosub_has_child_element = '';
		$this->autosub_has_smart_expand = '';
		
		if(($childcatcount > 0) && ($subcats != '') && ($item_menu_level < $group_level)){
			$html .= $this->getCategoriesAutoSub($category->getId(), true,$item_menu_level,$group_level,$group_menutype,$cat_image_type,$show_hide_cat_image,$item_parentId);
		
        }
		 $html .= '</li>';
    
    }
	 $html .= '</ul>';
	return $html;
}
public function subitemsavailable($parent_id)
{
$this->sub_items_available = array();
$current_storeid = Mage::app()->getStore()->getStoreId();
$menu_customer = Mage::getModel('navigationmenupro/customer');
$permission = $menu_customer->getUserPermission();
$subitemsavailable = Mage::getModel('navigationmenupro/menucreator')->getCollection()
				->setOrder("position","asc")
                ->addFieldToFilter('parent_id',$parent_id)
				->addFieldToFilter('status',"1")
				->addFieldToFilter('storeids', array(array('finset' => $current_storeid)))
				->addFieldToFilter('permission', array('in' => array($permission)));
foreach($subitemsavailable as $item){
	if(($item->getType() == "1"))
	{
	/* Check CMS Page is Active & From the Current Store Visible Or not*/
	$page_active_check = Mage::getModel('cms/page')->setStoreId($current_storeid)->load($item->getCmspageIdentifier())->getIsActive();
		if($page_active_check == "1")
		{
		$this->sub_items_available[$item->getMenuId()] = "1";
		}
	}else if(($item->getType() == "2"))
	{
	/* For Category Pages*/
		$cat_id = $item->getCategoryId();
		$allow_cat = Mage::getModel('navigationmenupro/category')->checkCagegoryAvailable($cat_id);
	
		$category = Mage::getModel('catalog/category');
		$category->setStoreId($current_storeid);
		$category = $category->load($cat_id);
		if(($category->getId()) && ($allow_cat == "1")) {
		$this->item_available = "1";
		$this->sub_items_available[$item->getMenuId()] = "1";
		}
	}else if(($item->getType() == "3"))
	{
		if($item->getStaticblockIdentifier() != '')
		{
		$active = Mage::getModel('cms/block')->setStoreId($current_storeid)->load($item->getStaticblockIdentifier())->getIsActive();
			if ($active == 1){
			$this->sub_items_available[$item->getMenuId()] = "1";
			}
		}
	}else if(($item->getType() == "4"))
	{ 
	$pro_id = $item->getProductId();
	$allow_pro = Mage::getModel('navigationmenupro/product')->checkProductavailable($pro_id);
	$product = Mage::getModel('catalog/product');
	$product->setStoreId($current_storeid);
	$product = $product->load($pro_id);
	if(($product->getId()) && ($allow_pro == "1")) {
		$this->sub_items_available[$item->getMenuId()] = "1";
		}
	}else if(($item->getType() == "login"))
	{
	/*For Login Menu*/
	if($menu_customer->isLoggedIn() != "1")
	{
	$this->sub_items_available[$item->getMenuId()] = "1";
	}
	}
	else if(($item->getType() == "logout"))
	{
	/*For Logout Menu*/
	if($menu_customer->isLoggedIn() == "1")
	{
	$this->sub_items_available[$item->getMenuId()] = "1";
	}
	}
	else if(($item->getType() == "register"))
	{
	/*For Register Menu*/
	if($menu_customer->isLoggedIn() != "1")
	{
		$this->sub_items_available[$item->getMenuId()] = "1";
	}
	}
	else{
	$this->sub_items_available[$item->getMenuId()] = "1";
	}
	
}

return $this->sub_items_available;
}
}
