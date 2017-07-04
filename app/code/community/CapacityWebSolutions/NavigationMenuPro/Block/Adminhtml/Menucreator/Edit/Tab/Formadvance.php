<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreator_Edit_Tab_Formadvance extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
 
      $form = new Varien_Data_Form();
      $this->setForm($form);
        $fieldset = $form->addFieldset('menuitem_form', array('legend' => Mage::helper('navigationmenupro')->__('Menu Item Advance Information')));
		 if ( Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData() )
		{
          
		  $form->setValues(Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData());
          $data = Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData();
		  Mage::getSingleton('adminhtml/session')->setMenucreatorgroupData(null);
		} elseif ( Mage::registry('menucreator_data') ) {
          $form->setValues(Mage::registry('menucreator_data')->getData());
		   $data = Mage::registry('menucreator_data')->getData();
		}
		
			$permissions = Mage::helper('navigationmenupro')->getPermission();
			
			$fieldset->addField('permission', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Access Permission'),
            'name' => 'permission',
			'values' => $permissions,
			));
			$fieldset->addField('target', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Target Window'),
            'name' => 'target',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('navigationmenupro')->__('Parent'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('navigationmenupro')->__('New Window'),
                ),
            ),
        ));
		/*Custom link title */
		$fieldset->addField('description', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Custom Link Title'),
            'name' => 'description',
        ));
		
		/*
		image_type
		*/
		
		if(isset($data['image']) && $data['image'] != ''){
            $imageLink = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'navigationmenupro/image/'.$data['image'];
			$imageName = $data['image'];
         
			$fieldset->addField('image_thumbnil', 'label', array(
                'label' => Mage::helper('navigationmenupro')->__('Upload item thumbnail'),
                'name'  =>'image_thumbnil',
                'after_element_html' => '<img src="'.$imageLink .'" alt=" '. $imageName .'" height="100" width="100" />',
            ));

			$fieldset->addField('image', 'file', array(
                'label' => Mage::helper('navigationmenupro')->__('Change thumbnail'),
                'required' => false,
                'name' => 'image',
            ));
			
			 $fieldset->addField('remove_img_main', 'checkbox', array(
            'label'     => Mage::helper('navigationmenupro')->__('Remove Image'),
            'name'      => 'remove_img_main',
			'onclick' => "this.value = this.checked ? 1 : 0;",
            ));

        }else{
            $fieldset->addField('image', 'image', array(
                'label' => Mage::helper('navigationmenupro')->__('Thumbnail'),
                'required' => false,
                'name' => 'image',
            ));
        }
		
		$fieldset->addField('image_status', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Show/Hide Thumbnail Image'),
            'name' => 'image_status',
			'values' => array(
                array(
					'label' => Mage::helper('navigationmenupro')->__('Please select'),
                ),
				array(
					'value' => 1,	
                    'label' => Mage::helper('navigationmenupro')->__('Show'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('navigationmenupro')->__('Hide'),
                ),
            ),
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
		
		return parent::_prepareForm();
  }
}