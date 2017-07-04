<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
        $fieldset = $form->addFieldset('groupmenu_form', array('legend' => Mage::helper('navigationmenupro')->__('Group Information')));
        
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));
		$menutitle = $fieldset->addField('showhidetitle', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Show Hide Group Title'),
			 'class' => 'required-entry',
            'required' => true,
            'name' => 'showhidetitle',
			'values' => Mage::helper('navigationmenupro')->getShowHideTitle() 
        )); 
		$titlecolor = $fieldset->addField('titlecolor','text',array(
                'name' => 'root[titlecolor]',
                'label' => Mage::helper('navigationmenupro')->__('Title Color'),
                'class' => 'color {required:false}'
            )
        ); 
		$titlebgcolor = $fieldset->addField('titlebgcolor','text',array(
                'name' => 'root[titlebgcolor]',
                'label' => __('Title Background Color'),
                'class' => 'color {required:false}'
            )
        ); 
         $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Status'),
            'name' => 'status',
            'values' => Mage::getModel('navigationmenupro/status')->getOptionArray() 
        ));
		
		 
		
		$menu_type = $fieldset->addField('menutype', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Menu Type'),
			'class' => 'required-entry',
            'required' => true,
            'name' => 'menutype',
			'onchange' => 'menutaboptions(this.value);',
			'onload' => 'menutaboptions(this.value);',
            'values' => Mage::helper('navigationmenupro')->getGroupMenuType() 
        ));
		
		$position = $fieldset->addField('position', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Alignment'),
            'name' => 'position',
			'class' => 'required-entry',
            'required' => true,
            'values' => array(
                array(
                    'value' => '',
                    'label' => Mage::helper('navigationmenupro')->__('Please Select Alignment'),
                ),
                
				array(
                    'value' => 'horizontal',
                    'label' => Mage::helper('navigationmenupro')->__('Horizontal'),
                ),
                array(
                    'value' => 'vertical',
                    'label' => Mage::helper('navigationmenupro')->__('Vertical'),
                ),
            ),
        ));
		$dropdownlevel = $fieldset->addField('level', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Item Level'),
			'class' => 'required-entry',
            'required' => true,
			'name' => 'level',
            'values' => Mage::helper('navigationmenupro')->getMenuLevel() 
        ));
		$fieldset->addField('direction', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Direction'),
			'class' => 'required-entry',
            'required' => true,
			'name' => 'direction',
            'values' => Mage::helper('navigationmenupro')->getDirection() 
        ));
		$fieldset->addField('image_height', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Image height'),
            'class' => 'required-entry validate-number',
            'name' => 'image_height',
			'required' => true,
			'after_element_html' => '<small>Image height set in px</small>',
        ));
		$fieldset->addField('image_width', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Image width'),
            'class' => 'required-entry validate-number',
            'name' => 'image_width',
			'required' => true,
			'after_element_html' => '<small>Image width set in px</small>',
        ));
		/*itemtextcolor*/
		 if ( Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData());
		  $data = Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData();
          Mage::getSingleton('adminhtml/session')->setMenucreatorgroupData(null);
      } elseif ( Mage::registry('menucreatorgroup_data') ) {
          $form->setValues(Mage::registry('menucreatorgroup_data')->getData());
		  $data = Mage::registry('menucreatorgroup_data')->getData();
      }
	  /* Set Default Value in the group form.*/
	  $id = $this->getRequest()->getParam('id');
	  if((empty($data)) && ($id == ''))
	  {
	  $data['titlecolor']='#FFFFFF';
	  $data['titlebgcolor']='#122736';
	  $data['image_height'] = '18';
	  $data['image_width'] = '18';
	  $data['level'] = '5';
	 }
	 if($id)
		{
			$informations = Mage::registry('menucreatorgroup_data')->getData();
			foreach($informations as $key => $value):
			if($this->isJSON($value)){
				$sub_information = json_decode($value, true);
				foreach($sub_information as $subkey => $subvalue):
						$informations[$subkey] = $subvalue;	
					endforeach;
			}else{
				$informations[$key] = $value;	
			}
			endforeach;
			
			$form->setValues($informations);
		}
		else
		{
			$form->setValues($data);
		}
	  
	    $this->setForm($form);
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($menu_type->getHtmlId(), $menu_type->getName())
			->addFieldMap($position->getHtmlId(), $position->getName())
			->addFieldDependence(
                $position->getName(),
				$menu_type->getName(),
				'mega-menu'
            )
        );	 
        return parent::_prepareForm();
  }
  public function isJSON($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}
  
}