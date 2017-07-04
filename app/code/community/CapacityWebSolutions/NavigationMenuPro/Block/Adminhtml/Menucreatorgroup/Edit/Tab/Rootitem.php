<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup_Edit_Tab_Rootitem extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
	    $fieldset = $form->addFieldset('groupmenu_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Menu Bar')));
        
		$fieldset->addField('menubgcolor','text',array(
				'name' => 'root[menubgcolor]',
				'label' => Mage::helper('navigationmenupro')->__('Background Color'),
                'class' => 'color {required:false}',
            )
        ); 
		$fieldset->addField('menupadding','text',
            array(
                'name' => 'root[menupadding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		$fieldset->addField(
            'menu_width',
            'text',
            array(
                'name' => 'root[menu_width]',
				'label' => Mage::helper('navigationmenupro')->__('Menu Width'),
                'title' => __('Menu Width'),
                'required' => false,
				'note' => 'Set in px',
			)
        );
		 $fieldset = $form->addFieldset('dropdown_form_color_items', array('legend' => Mage::helper('navigationmenupro')->__('Root Level Items')));

		$fieldset->addField(
            'lvl0color',
            'text',
            array(
                'name' => 'root[lvl0color]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'lvl0size',
            'text',
            array(
                'name' => 'root[lvl0size]',
                'label' => Mage::helper('navigationmenupro')->__('Font Size'),
            )
        );
		$fieldset->addField(
            'lvl0weight',
            'text',
            array(
                'name' => 'root[lvl0weight]',
                'label' => Mage::helper('navigationmenupro')->__('Font Weight'),
            )
        );
		$fieldset->addField(
            'lvl0case',
            'select',
            array(
                'name' => 'root[lvl0case]',
                'label' => Mage::helper('navigationmenupro')->__('Font Transform'),
				'values' => Mage::helper('navigationmenupro')->getFontTransform() 
            )
        );
		$fieldset->addField(
            'lvl0bgcolor',
            'text',
            array(
                'name' => 'root[lvl0bgcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'lvl0padding',
            'text',
            array(
                'name' => 'root[lvl0padding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 10px 15px 10px 15px (Top Right Bottom Left)',
            )
        );
		
		$fieldset->addField(
            'lvl0corner',
            'text',
            array(
                'name' => 'root[lvl0corner]',
                'label' => Mage::helper('navigationmenupro')->__('Rounded Corners'),
				'note' => 'Ex: 5px 10px 5px 10px (Top-left Top-Right Bottom-Right Bottom-Left)',
				
            )
        );
		$dividershow = $fieldset->addField(
            'lvl0showdivider',
            'select',
            array(
                'name' => 'root[lvl0showdivider]',
                'label' => Mage::helper('navigationmenupro')->__('Show Divider'),
                'title' => __('Show Divider'),
                'values' =>Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
				
            )
        );
		
		$dividercolor = $fieldset->addField(
            'lvl0dvcolor',
            'text',
            array(
                'name' => 'root[lvl0dvcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Divider Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'lvl0arw',
            'select',
            array(
                'name' => 'root[lvl0arw]',
                'label' => Mage::helper('navigationmenupro')->__('Show Arrow'),
				'title' => __('Show Divider'),
				'values' =>Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            )
        );
		 $fieldset = $form->addFieldset('top_link_hover', array('legend' => Mage::helper('navigationmenupro')->__('Root Level Items on Hover')));
		
		$fieldset->addField(
            'lvl0colorh',
            'text',
            array(
                'name' => 'root[lvl0colorh]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		
		$fieldset->addField(
            'lvl0bgcolorh',
            'text',
            array(
                'name' => 'root[lvl0bgcolorh]',
				'label' => Mage::helper('navigationmenupro')->__('Background Color'),
                'class' => 'color {required:false}'
            )
        );
		 $fieldset = $form->addFieldset('top_link_active', array('legend' => Mage::helper('navigationmenupro')->__('Root Level Items on Active')));
		
		$fieldset->addField(
            'lvl0colora',
            'text',
            array(
                'name' => 'root[lvl0colora]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'lvl0bgcolora',
            'text',
            array(
                'name' => 'root[lvl0bgcolora]',
				'label' => Mage::helper('navigationmenupro')->__('Background Color'),
                'class' => 'color {required:false}'
            )
        );
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
	  /* Menu Bar Options */
		$data['menubgcolor'] = '#F2F2F2';  
		$data['menupadding']='0px 0px 0px 0px';
		$data['menu_width']='1200px';	
		/*  Root Level Items  Options */		
		$data['lvl0color']='#122736';		
		$data['lvl0size']='15px';	
		$data['lvl0weight']='bold';		
		$data['lvl0case']='uppercase';	
		$data['lvl0bgcolor']='#F2F2F2';		
		$data['lvl0padding']='10px 15px 10px 15px';	
		//$data['lvl0spaccing']='0';
		$data['lvl0corner']='0px 0px 0px 0px';		
		$data['lvl0showdivider']='1';	
		$data['lvl0dvcolor']='#E1E1E1';		
		$data['lvl0arw']='1';
		/*Root Level Items on Hover Options */ 
		$data['lvl0colorh'] = '#FFFFFF';
		$data['lvl0bgcolorh'] = '#FE5656';
		/* Root Level Items on Active Options*/
		$data['lvl0colora'] = '#FE5656';
		$data['lvl0bgcolora'] = '#FFFFFF';
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
            ->addFieldMap($dividershow->getHtmlId(), $dividershow->getName())
			->addFieldMap($dividercolor->getHtmlId(), $dividercolor->getName())
			->addFieldDependence(
                $dividercolor->getName(),
				$dividershow->getName(),
				'1'
            )
			
        );	 
        return parent::_prepareForm();
  }
  public function isJSON($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}
  
}