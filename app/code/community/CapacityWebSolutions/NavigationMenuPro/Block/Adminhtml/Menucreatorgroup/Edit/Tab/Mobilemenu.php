<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup_Edit_Tab_Mobilemenu extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
	    $fieldset = $form->addFieldset('mm_groupmenu_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Menu Bar')));
         
		$fieldset->addField('responsive_breakpoint','text',array(
				'name' => 'mobilemenu[responsive_breakpoint]',
				'label' => Mage::helper('navigationmenupro')->__('Responsive Break Point'),
				'note' => 'Set Responsive Break point value in px.',
                
            )
        ); 
		
		$fieldset->addField('mopnl-bgcolor','text',array(
				'name' => 'mobilemenu[mopnl-bgcolor]',
				'label' => Mage::helper('navigationmenupro')->__('Background Color'),
                'class' => 'color {required:false}',
            )
        ); 
		$fieldset->addField('mopnl-padding','text',
            array(
                'name' => 'mobilemenu[mopnl-padding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		
		$fieldset->addField(
            'mopnl-borderwidth',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-borderwidth]',
                'label' => Mage::helper('navigationmenupro')->__('Border Width'),
				'note' => 'Ex: 5px 10px 5px 10px (Top-left Top-Right Bottom-Right Bottom-Left)',
				
            )
        );
		
		$fieldset->addField(
            'mopnl-bordercolor',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-bordercolor]',
				'label' => Mage::helper('navigationmenupro')->__('Border Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mopnl-lvl0corner',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-lvl0corner]',
                'label' => Mage::helper('navigationmenupro')->__('Rounded Corners'),
				'note' => 'Ex: 5px 10px 5px 10px (Top-left Top-Right Bottom-Right Bottom-Left)',
				
            )
        );
		 $fieldset = $form->addFieldset('mm_dropdown_form_color_items', array('legend' => Mage::helper('navigationmenupro')->__('Root Level Items')));

		$fieldset->addField(
            'mopnl-lvl0color',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-lvl0color]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mopnl-lvl0size',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-lvl0size]',
                'label' => Mage::helper('navigationmenupro')->__('Font Size'),
            )
        );
		$fieldset->addField(
            'mopnl-lvl0weight',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-lvl0weight]',
                'label' => Mage::helper('navigationmenupro')->__('Font Weight'),
            )
        );
		$fieldset->addField(
            'mopnl-lvl0case',
            'select',
            array(
                'name' => 'mobilemenu[mopnl-lvl0case]',
                'label' => Mage::helper('navigationmenupro')->__('Font Transform'),
				'values' => Mage::helper('navigationmenupro')->getFontTransform() 
            )
        );
		$fieldset->addField(
            'mopnl-lvl0bgcolor',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-lvl0bgcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mopnl-lvl0padding',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-lvl0padding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 10px 15px 10px 15px (Top Right Bottom Left)',
            )
        );
		
		
		$fieldset->addField(
            'mopnl-lvl0dvcolor',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-lvl0dvcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Divider Color'),
                'class' => 'color {required:false}'
            )
        );
		
		 
		 $fieldset = $form->addFieldset('mm_top_link_active', array('legend' => Mage::helper('navigationmenupro')->__('Root Level Items on Active')));
		
		$fieldset->addField(
            'mopnl-lvl0colora',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-lvl0colora]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mopnl-lvl0bgcolora',
            'text',
            array(
                'name' => 'mobilemenu[mopnl-lvl0bgcolora]',
				'label' => Mage::helper('navigationmenupro')->__('Background Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('mm_top_link_hover', array('legend' => Mage::helper('navigationmenupro')->__('Sub Level Items')));
		$fieldset->addField(
            'mopnl-sublvlcolor',
            'select',
            array(
                'name' => 'mobilemenu[mopnl-sublvlcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Sub Level Color'),
				'note' => 'choose color shade for sub menu items',
				'values' =>Mage::helper('navigationmenupro')->getSubLevelColor()
				
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
		  $data['responsive_breakpoint'] = '767px';  
		/* Menu Bar Options */
		$data['mopnl-bgcolor'] = '#F2F2F2';  
		$data['mopnl-padding']='0px 0px 0px 0px';
		$data['mopnl-borderwidth']='5px 0px 0px 0px';
		
		//$data['mmmenu_width']='1200px';	
		/*  Root Level Items  Options */	
		$data['mopnl-bordercolor']='#FE5656';		
		$data['mopnl-lvl0corner']='0px 0px 0px 0px';		
		$data['mopnl-lvl0size']='15px';	
		$data['mopnl-lvl0weight']='bold';		
		$data['mopnl-lvl0case']='uppercase';	
		$data['mopnl-lvl0bgcolor']='#F2F2F2';		
		$data['mopnl-lvl0padding']='10px 15px 10px 15px';	
		//$data['lvl0spaccing']='0';
			
			
		//$data['mmlvl0showdivider']='1';	
		$data['mopnl-lvl0dvcolor']='#FE3BDE';		
		//$data['mmlvl0arw']='1';
		/*Root Level Items on Hover Options */ 
		$data['mopnl-sublvlcolor'] = '#FFFFFF';
		/* Root Level Items on Active Options*/
		$data['mopnl-lvl0color'] = '#122736';
		
		$data['mopnl-lvl0colora'] = '#FE5656';
		
		$data['mopnl-lvl0bgcolora'] = '#FFFFFF';
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
        
        return parent::_prepareForm();
  }
  public function isJSON($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}
  
}