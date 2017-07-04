<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
error_reporting(0);
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreator_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
 
      $form = new Varien_Data_Form();
      $this->setForm($form);
	  
        $fieldset = $form->addFieldset('menuitem_form', array('legend' => Mage::helper('navigationmenupro')->__('Menu Item General Information')));
		 if ( Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData() )
		{
          
		  $form->setValues(Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData());
          $data = Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData();
		  Mage::getSingleton('adminhtml/session')->setMenucreatorgroupData(null);
		} elseif ( Mage::registry('menucreator_data') ) {
          $form->setValues(Mage::registry('menucreator_data')->getData());
		   $data = Mage::registry('menucreator_data')->getData();
		}
		
		if(isset($data['autosub']))
		{
			if($data['autosub']==1)
			{
				$check = '1';
			}else
			{
				$check = '0';
			}
		}else
		{
				$check = '0';
		}
		if(isset($data['use_category_title']))
		{
			if($data['use_category_title']==1)
			{
				$cat_title = '1';
			}else
			{
				$cat_title = '0';
			}
		}else
		{
				$cat_title = '0';
		}
		$groupData = Mage::getModel('navigationmenupro/menucreatorgroup')->getAllGroup();
		
		$menu_type_option = $fieldset->addField('type', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Menu Type'),
            'class' => 'required-entry',
            'required' => true,
			'onchange'   => 'menutype(this.value)',
            'name' => 'type',
			
			'values' => array(
			array(
                    'label' => Mage::helper('navigationmenupro')->__('Select Menu Type'),
                ),
				array(
                    'value' => 1,
                    'label' => Mage::helper('navigationmenupro')->__('CMS Page'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('navigationmenupro')->__('Category Page'),
                ),
				array(
                    'value' => 3,
                    'label' => Mage::helper('navigationmenupro')->__('Static Block'),
                ),
                array(
                    'value' => 4,
                    'label' => Mage::helper('navigationmenupro')->__('Product Page'),
                ),
				array(
                    'value' => 5,
                    'label' => Mage::helper('navigationmenupro')->__('Custom Url'),
                ),
				array(
                    'value' => 6,
                    'label' => Mage::helper('navigationmenupro')->__('Alias [href=#]'),
                ),
				array(
                    'value' => 'account',
                    'label' => Mage::helper('navigationmenupro')->__('My Account'),
                ),
				array(
                    'value' => 'cart',
                    'label' => Mage::helper('navigationmenupro')->__('My Cart'),
                ),
				array(
                    'value' => 'wishlist',
                    'label' => Mage::helper('navigationmenupro')->__('My Wishlist'),
                ),
				array(
                    'value' => 'checkout',
                    'label' => Mage::helper('navigationmenupro')->__('Checkout'),
                ),
				array(
                    'value' => 'login',
                    'label' => Mage::helper('navigationmenupro')->__('Login'),
                ),
				array(
                    'value' => 'logout',
                    'label' => Mage::helper('navigationmenupro')->__('Logout'),
                ),
				array(
                    'value' => 'register',
                    'label' => Mage::helper('navigationmenupro')->__('Register'),
                ),
				array(
                    'value' => 'contact',
                    'label' => Mage::helper('navigationmenupro')->__('Contact Us'),
                )
            ),
			'value' => '1'
			
        ));
	
				$categories = Mage::getModel('catalog/category')->getCollection()
								->addAttributeToSelect('*')
								->addAttributeToFilter('level', 1)
								->addAttributeToFilter('is_active', 1);
				$parent_categories = $categories->getData();
				
				$cat_list = array();
				$cat_head = array(array(
				 'label' => Mage::helper('navigationmenupro')->__('Please Select Category'),
				));
				$cat_list = array_merge($cat_list,$cat_head);
				foreach($parent_categories as $key => $value):
				$parent_category = Mage::getModel('catalog/category')->load($value['entity_id']);
				$Parent_Cat[] = array(
                    'label' => Mage::helper('navigationmenupro')->__($parent_category->getName(). "  (Root)  "),
					'value' => Mage::helper('navigationmenupro')->__($parent_category->getId()),
                );
				$Categories_list = Mage::getModel("navigationmenupro/menucreator")->getCategorieslistform($value['entity_id'],true);
				
				/*Add Root Category Lable In the All It's Sub Category*/
				$parent_cat_add = array_merge($Parent_Cat,$Categories_list);
				$Parent_Cat = array();
				
				/* Add Two Root Category and it's Sub Category*/
				$cat_list = array_merge($cat_list,$parent_cat_add);
				endforeach;
				
		$category = $fieldset->addField('category_id', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Select Category'),
			'class' => 'required-entry',
            'required' => true,
			'name' => 'category_id',
			'onchange'   => 'cat_title()',
			'values' => $cat_list,
			
			));
			
			
		$category_autosub = $fieldset->addField('autosub', 'checkbox', array(
			'label'    => Mage::helper('navigationmenupro')->__('Auto Show Sub-Categories'),
			'name'     => 'autosub',
			'checked' => $check,
			'onclick'  => "this.value = this.checked ? 1 : 0;",
			'values'   => 'autosub'
			));
		$category_usetitle =	$fieldset->addField('use_category_title', 'checkbox', array(
			'label'     => Mage::helper('navigationmenupro')->__('Change Menu Title'),
			'name'      => 'use_category_title',
			'checked' => $cat_title,
			'onclick' => "change_title()",
			'value'  => '0',
			));
		 	$image_type = $fieldset->addField('image_type', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Show Category Image'),
            'name' => 'image_type',
			'disabled' => true,
			'values' => array(
                array(
					'value' => 'none',	
                    'label' => Mage::helper('navigationmenupro')->__('None'),
                ),
				array(
					'value' => 'thumbnail_image',	
                    'label' => Mage::helper('navigationmenupro')->__('Show category thumbnail image in menu'),
                ),
                array(
                    'value' => 'main_image',
                    'label' => Mage::helper('navigationmenupro')->__('Show category image in menu'),
                ),
            ),
			));
        $cms_pages_collection = Mage::getModel('cms/page')->getCollection();
		$cms_collection = array();
		$cms_collection[] = array(
                    'label' => Mage::helper('navigationmenupro')->__('Please Select Cms Page'),
                );
		foreach($cms_pages_collection as $cms_key => $cms_value):
		if($cms_value->getIsActive() == "1")
		{
		$cms_collection[] = array(
                    'value' => $cms_value->getIdentifier(),
                    'label' => Mage::helper('navigationmenupro')->__($cms_value->getTitle()),
                );
		}
		endforeach;
		
		$cmspage = $fieldset->addField('cmspage_identifier', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Select Cms Pages'),
			'class' => 'required-entry',
            'required' => true,
			'name' => 'cmspage_identifier',
			'onchange'   => 'cms_title()',
			'value' => 1,
			'values' => $cms_collection,
			));
		
		$static_block_collection = Mage::getModel('cms/block')->getCollection();
		$static_blocks = array();
		$static_blocks[] = array(
                    'label' => Mage::helper('navigationmenupro')->__('Please Select Static Block'),
                );
		foreach($static_block_collection as $block_key => $block_value):
		if($block_value->getIsActive() == "1")
		{
		$static_blocks[] = array(
                    'value' => $block_value->getIdentifier(),
                    'label' => Mage::helper('navigationmenupro')->__($block_value->getTitle()),
                );
		}
		endforeach;
		$staticblock = $fieldset->addField('staticblock_identifier', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Select Static Block'),
			'class' => 'required-entry',
            'required' => true,
			'name' => 'staticblock_identifier',
			'onchange'   => 'staticblock_title()',
			'values' => $static_blocks,
			));
			/*product_id*/
		$productid = $fieldset->addField('product_id', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Product Id'),
            'class' => 'required-entry validate-number',
            'required' => true,
			'name' => 'product_id',
		));
		
		$customurl = $fieldset->addField('url_value', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Custom Url'),
            'class' => 'required-entry',
			'required' => true,
			'name' => 'url_value'
		));
		 
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
			
        ));
		
		$fieldset->addField('class_subfix', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Add Custom Class'),
            'name' => 'class_subfix',
        ));
		
        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Status'),
            'name' => 'status',
            'values' => Mage::getModel('navigationmenupro/status')->getOptionArray()
        ));
		
		
		$current_menu_id = $this->getRequest()->getParam('id');
		if($current_menu_id == '')
		{
		$url = Mage::helper('adminhtml')->getUrl('adminhtml/menudata/parent');
		}else
		{
		$url = Mage::helper("adminhtml")->getUrl("adminhtml/menudata/parent/",array("current_menu"=> $current_menu_id));
		}
	
		
		$fieldset->addField('group_id', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Assign Menu Group'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'group_id',
			'onload'   => 'parent_item(this.value,\''.$url.'\')',
			'onchange'   => 'parent_item(this.value,\''.$url.'\')',
			'values' => $groupData
			));
			
		$parent_item = $fieldset->addField('parent_id', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Parent Item'),
            'class' => 'required-entry',
            'required' => true,
			'value' => '0',
            'name' => 'parent_id',
			'values' => array(
                array(
                    'label' => Mage::helper('navigationmenupro')->__('Please Select Parent'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('navigationmenupro')->__('Root'),
                ),
            ),
			));
			$store_swatcher = Mage::helper('navigationmenupro')->getstore_swatcher();
			
			if (!Mage::app()->isSingleStoreMode()) {
    $fieldset->addField('storeids', 'multiselect', array(
        'name' => 'storeids[]',
        'label' => Mage::helper('navigationmenupro')->__('Store View'),
        'title' => Mage::helper('navigationmenupro')->__('Store View'),
        'required' => true,
        'values' => Mage::getSingleton('adminhtml/system_store')
                     ->getStoreValuesForForm(false, true),
    ));
}
else {
    $fieldset->addField('storeids', 'hidden', array(
        'name' => 'storeids[]',
        'value' => Mage::app()->getStore(true)->getId()
    ));
}
		
		$subcolumnlayout = $fieldset->addField('subcolumnlayout', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Sub Column Layout'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'subcolumnlayout',
			'values' => Mage::helper('navigationmenupro')->columnLayout()));
		$menu_align = $fieldset->addField('text_align', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Text Align'),
			'class' => 'required-entry',
            'required' => true,
            'name' => 'text_align',
			'values' => Mage::helper('navigationmenupro')->getAlignment()
			));
		if ( Mage::getSingleton('adminhtml/session')->getMenucreatorData() )
		{
          
		  $form->setValues(Mage::getSingleton('adminhtml/session')->getMenucreatorData());
          $data = Mage::getSingleton('adminhtml/session')->getMenucreatorData();
		  Mage::getSingleton('adminhtml/session')->setMenucreatorData(null);
		} elseif ( Mage::registry('menucreator_data') ) {
          $form->setValues(Mage::registry('menucreator_data')->getData());
		   $data = Mage::registry('menucreator_data')->getData();
		}
		 $form->setValues($data);
 
        $this->setForm($form);
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($menu_type_option->getHtmlId(), $menu_type_option->getName())
			->addFieldMap($category->getHtmlId(), $category->getName())
			->addFieldMap($category_autosub->getHtmlId(), $category_autosub->getName())
			->addFieldMap($category_usetitle->getHtmlId(), $category_usetitle->getName())
			->addFieldMap($image_type->getHtmlId(), $image_type->getName())
			->addFieldMap($cmspage->getHtmlId(), $cmspage->getName())
			->addFieldMap($staticblock->getHtmlId(), $staticblock->getName())
			->addFieldMap($productid->getHtmlId(), $productid->getName())
			->addFieldMap($customurl->getHtmlId(), $customurl->getName())
			->addFieldMap($parent_item->getHtmlId(), $parent_item->getName())
			->addFieldMap($subcolumnlayout->getHtmlId(), $subcolumnlayout->getName())
			->addFieldMap($menu_align->getHtmlId(), $menu_align->getName())
			->addFieldDependence(
                $cmspage->getName(),
				$menu_type_option->getName(),
				1
            )
			->addFieldDependence(
                $category->getName(),
				$menu_type_option->getName(),
				2
            )
			->addFieldDependence(
                $category_autosub->getName(),
				$menu_type_option->getName(),
				2
            )
			->addFieldDependence(
                $category_usetitle->getName(),
				$menu_type_option->getName(),
				2
            )
			->addFieldDependence(
                $image_type->getName(),
				$menu_type_option->getName(),
				2
            )
			->addFieldDependence(
                $staticblock->getName(),
				$menu_type_option->getName(),
				3
            )
			->addFieldDependence(
                $productid->getName(),
				$menu_type_option->getName(),
				4
            )
			->addFieldDependence(
                $customurl->getName(),
				$menu_type_option->getName(),
				5
            )
			->addFieldDependence(
                $subcolumnlayout->getName(),
				$parent_item->getName(),
				0)
				->addFieldDependence(
                $menu_align->getName(),
				$parent_item->getName(),
				0)
				
            
        );	 
		return parent::_prepareForm();
  }
}