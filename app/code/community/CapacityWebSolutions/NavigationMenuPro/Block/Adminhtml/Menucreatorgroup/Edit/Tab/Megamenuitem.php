<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup_Edit_Tab_Megamenuitem extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
	    $fieldset = $form->addFieldset('megaparent_form_color', array('legend' => Mage::helper('navigationmenupro')->__('MegaMenu Panel')));
        
		$fieldset->addField(
            'mmpnl-padding',
            'text',
            array(
                'name' => 'mega[mmpnl-padding]',
                'label' => __('Padding'),
				'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		
		$fieldset->addField(
            'mmpnl-bgcolor',
            'text',
            array(
                'name' => 'mega[mmpnl-bgcolor]',
				'label' => Mage::helper('navigationmenupro')->__('Background Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmpnl-bdwidth',
            'text',
            array(
                'name' => 'mega[mmpnl-bdwidth]',
				'label' => Mage::helper('navigationmenupro')->__('Border Width'),
                'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		$fieldset->addField(
            'mmpnl-bdcolor',
            'text',
            array(
                'name' => 'mega[mmpnl-bdcolor]',
				'label' => Mage::helper('navigationmenupro')->__('Border Color'),
                'class' => 'color {required:false}'
            )
        );
		
		$fieldset->addField(
            'mmpnl-corner',
            'text',
            array(
                'name' => 'mega[mmpnl-corner]',
				'label' => Mage::helper('navigationmenupro')->__('Mega Menu Rounded Corner'),
                'note' => 'Ex: 5px 10px 5px 10px (Top-left Top-Right Bottom-Right Bottom-Left)',
            )
        );
		
		$fieldset->addField(
            'mmpnl-clm-padding',
            'text',
            array(
                'name' => 'mega[mmpnl-clm-padding]',
				'label' => Mage::helper('navigationmenupro')->__('Mega Menu Column Padding'),
                'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		
		
		$fieldset = $form->addFieldset('megaitem_form_color', array('legend' => Mage::helper('navigationmenupro')->__('First Level Items')));
		
		$fieldset->addField(
            'mmlvl1color',
            'text',
            array(
                'name' => 'mega[mmlvl1color]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl1size',
            'text',
            array(
                'name' => 'mega[mmlvl1size]',
                'label' => Mage::helper('navigationmenupro')->__('Font Size'),
            )
        );
		$fieldset->addField(
            'mmlvl1weight',
            'text',
            array(
                'name' => 'mega[mmlvl1weight]',
				'label' => Mage::helper('navigationmenupro')->__('Font Weight'),
            )
        );
		$fieldset->addField(
            'mmlvl1case',
            'select',
            array(
                'name' => 'mega[mmlvl1case]',
                'label' => Mage::helper('navigationmenupro')->__('Font Transform'),
				'values' => Mage::helper('navigationmenupro')->getFontTransform() 
            )
        );
		$fieldset->addField(
            'mmlvl1bgcolor',
            'text',
            array(
                'name' => 'mega[mmlvl1bgcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl1padding',
            'text',
            array(
                'name' => 'mega[mmlvl1padding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		$megalvl1dividershow = $fieldset->addField(
            'mmlvl1showdivider',
            'select',
            array(
                'name' => 'mega[mmlvl1showdivider]',
                'label' => __('Show Divider'),
                'label' => Mage::helper('navigationmenupro')->__('Show Divider'),
                'values' =>Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            )
        );
		
		$megalvl1dividercolor = $fieldset->addField(
            'mmlvl1dvcolor',
            'text',
            array(
                'name' => 'mega[mmlvl1dvcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Divider Color'),
                'class' => 'color {required:false}'
            )
        );
		 $fieldset = $form->addFieldset('mgfrstitem_hover', array('legend' => Mage::helper('navigationmenupro')->__('First Level Items on Hover')));
		 
		
		$fieldset->addField(
            'mmlvl1colorh',
            'text',
            array(
                'name' => 'mega[mmlvl1colorh]',
                 'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl1bgcolorh',
            'text',
            array(
                'name' => 'mega[mmlvl1bgcolorh]',
				 'label' => Mage::helper('navigationmenupro')->__('Background Color'),
                'class' => 'color {required:false}'
            )
        );
		 $fieldset = $form->addFieldset('mgfrstitem_active', array('legend' => Mage::helper('navigationmenupro')->__('First Level Items on Active')));
		
		$fieldset->addField(
            'mmlvl1colora',
            'text',
            array(
                'name' => 'mega[mmlvl1colora]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl1bgcolora',
            'text',
            array(
                'name' => 'mega[mmlvl1bgcolora]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		
		$fieldset = $form->addFieldset('megaseconditem_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Second Level Items')));
		
		$fieldset->addField(
            'mmlvl2color',
            'text',
            array(
                'name' => 'mega[mmlvl2color]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl2size',
            'text',
            array(
                'name' => 'mega[mmlvl2size]',
				'label' => Mage::helper('navigationmenupro')->__('Font Size'),
            )
        );
		$fieldset->addField(
            'mmlvl2weight',
            'text',
            array(
                'name' => 'mega[mmlvl2weight]',
                'label' => Mage::helper('navigationmenupro')->__('Font Weight'),
				
            )
        );
		$fieldset->addField(
            'mmlvl2case',
            'select',
            array(
                'name' => 'mega[mmlvl2case]',
                'label' => Mage::helper('navigationmenupro')->__('Font Transform'),
				'values' => Mage::helper('navigationmenupro')->getFontTransform() 
            )
        );
		$fieldset->addField(
            'mmlvl2bgcolor',
            'text',
            array(
                'name' => 'mega[mmlvl2bgcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl2padding',
            'text',
            array(
                'name' => 'mega[mmlvl2padding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		
		 $megalvl2dividershow = $fieldset->addField(
            'mmlvl2showdivider',
            'select',
            array(
                'name' => 'mega[mmlvl2showdivider]',
                'label' => Mage::helper('navigationmenupro')->__('Show Divider'),
                'title' => __('Show Divider'),
                'values' =>Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            )
        );
		
		$megalvl2dividercolor = $fieldset->addField(
            'mmlvl2dvcolor',
            'text',
            array(
                'name' => 'mega[mmlvl2dvcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Divider Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('mgsecitem_hover', array('legend' => Mage::helper('navigationmenupro')->__('Second Level Items on Hover')));
		$fieldset->addField(
            'mmlvl2colorh',
            'text',
            array(
                'name' => 'mega[mmlvl2colorh]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl2bgcolorh',
            'text',
            array(
                'name' => 'mega[mmlvl2bgcolorh]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('mgsecitem_active', array('legend' => Mage::helper('navigationmenupro')->__('Second Level Items on Active')));
		$fieldset->addField(
            'mmlvl2colora',
            'text',
            array(
                'name' => 'mega[mmlvl2colora]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl2bgcolora',
            'text',
            array(
                'name' => 'mega[mmlvl2bgcolora]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('megathirditem_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Third Level Items')));
		$fieldset->addField(
            'mmlvl3color',
            'text',
            array(
                'name' => 'mega[mmlvl3color]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl3size',
            'text',
            array(
                'name' => 'mega[mmlvl3size]',
				'label' => Mage::helper('navigationmenupro')->__('Font Size'),
            )
        );
		$fieldset->addField(
            'mmlvl3weight',
            'text',
            array(
                'name' => 'mega[mmlvl3weight]',
                'label' => Mage::helper('navigationmenupro')->__('Font Weight'),
				
            )
        );
		$fieldset->addField(
            'mmlvl3case',
            'select',
            array(
                'name' => 'mega[mmlvl3case]',
                'label' => Mage::helper('navigationmenupro')->__('Font Transform'),
				'values' => Mage::helper('navigationmenupro')->getFontTransform() 
            )
        );
		$fieldset->addField(
            'mmlvl3bgcolor',
            'text',
            array(
                'name' => 'mega[mmlvl3bgcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl3padding',
            'text',
            array(
                'name' => 'mega[mmlvl3padding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		
		 $megalvl3dividershow = $fieldset->addField(
            'mmlvl3showdivider',
            'select',
            array(
                'name' => 'mega[mmlvl3showdivider]',
				'label' => Mage::helper('navigationmenupro')->__('Show Divider'),
                'title' => __('Show Divider'),
                'values' =>Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            )
        );
		
		$megalvl3dividercolor = $fieldset->addField(
            'mmlvl3dvcolor',
            'text',
            array(
                'name' => 'mega[mmlvl3dvcolor]',
				'label' => Mage::helper('navigationmenupro')->__('Divider Color'),
                'class' => 'color {required:false}'
            )
        );
		
		$fieldset = $form->addFieldset('mgthirditem_hover', array('legend' => Mage::helper('navigationmenupro')->__('Third Level Items on Hover')));
		
		$fieldset->addField(
            'mmlvl3colorh',
            'text',
            array(
                'name' => 'mega[mmlvl3colorh]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl3bgcolorh',
            'text',
            array(
                'name' => 'mega[mmlvl3bgcolorh]',
				'label' => Mage::helper('navigationmenupro')->__('Background Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('mgthirditem_active', array('legend' => Mage::helper('navigationmenupro')->__('Third Level Items on Active')));
		
		$fieldset->addField(
            'mmlvl3colora',
            'text',
            array(
                'name' => 'mega[mmlvl3colora]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'mmlvl3bgcolora',
            'text',
            array(
                'name' => 'mega[mmlvl3bgcolora]',
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
	   if((empty($data)) && ($id == '')) {
		/* MegaMenu Panel  Options*/
		$data['mmpnl-padding']= '15px 10px 15px 10px';
		$data['mmpnl-bgcolor']= '#FFFFFF';
		$data['mmpnl-bdwidth']= '5px 0px 0px 0px';
		$data['mmpnl-bdcolor']= '#FE5656';
		$data['mmpnl-corner']= '10px 10px 10px 10px';
		$data['mmpnl-clm-padding']= '0px 10px 10px 10px';
		 /* First Level Items Options */
		$data['mmlvl1color']='#FE5656';
		$data['mmlvl1size']='15px';
		$data['mmlvl1weight']='700';
		$data['mmlvl1case']='uppercase';
		$data['mmlvl1bgcolor']='#F2F2F2';
		$data['mmlvl1padding']='10px 10px 10px 10px';
		$data['mmlvl1showdivider']= '1';
		$data['mmlvl1dvcolor']='#DDDDDD';
		/* First Level Items on Hover Options */
		$data['mmlvl1colorh']= '#FE5656';
		$data['mmlvl1bgcolorh']='#E3E3E3';
		/* First Level Items on Active Options */
		$data['mmlvl1colora']= '#FE5656';
		$data['mmlvl1bgcolora']='#E3E3E3';
		 /* Second Level Items Options */
		$data['mmlvl2color']='#333333';
		$data['mmlvl2size']='14px';
		$data['mmlvl2weight']='600';
		$data['mmlvl2case']='inherit';
		$data['mmlvl2bgcolor']='#FFFFFF';
		$data['mmlvl2padding']='8px 8px 8px 10px';
		$data['mmlvl2showdivider']= '1';
		$data['mmlvl2dvcolor']='#EEEEEE';
		/* Second Level Items on Hover Options */
		$data['mmlvl2colorh']= '#000000';
		$data['mmlvl2bgcolorh']='#F3F3F3';
		/* Second Level Items on Active Options */
		$data['mmlvl2colora']= '#FE5656';
		$data['mmlvl2bgcolora']='#FFFFFF';
		 /* Third Level Items Options */
		$data['mmlvl3color']='#333333';
		$data['mmlvl3size']='13px';
		$data['mmlvl3weight']='400';
		$data['mmlvl3case']='inherit';
		$data['mmlvl3bgcolor']='#FFFFFF';
		$data['mmlvl3padding']='8px 8px 8px 20px';
		$data['mmlvl3showdivider']= '1';
		$data['mmlvl3dvcolor']='#EEEEEE';
		/* Third Level Items on Hover Options */
		$data['mmlvl3colorh']= '#000000';
		$data['mmlvl3bgcolorh']='#F3F3F3';
		/* Third Level Items on Active Options */
		$data['mmlvl3colora']= '#FE5656';
		$data['mmlvl3bgcolora']='#FFFFFF';
		}
	  if($id)
		{
       $informations = Mage::registry('menucreatorgroup_data')->getData();
			if(!empty($informations)){
				
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
		}
		else
		{
			$form->setValues($data);
		}
	    $this->setForm($form);
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($megalvl1dividershow->getHtmlId(), $megalvl1dividershow->getName())
			->addFieldMap($megalvl1dividercolor->getHtmlId(), $megalvl1dividercolor->getName())
			->addFieldMap($megalvl2dividershow->getHtmlId(), $megalvl2dividershow->getName())
			->addFieldMap($megalvl2dividercolor->getHtmlId(), $megalvl2dividercolor->getName())
			->addFieldMap($megalvl3dividershow->getHtmlId(), $megalvl3dividershow->getName())
			->addFieldMap($megalvl3dividercolor->getHtmlId(), $megalvl3dividercolor->getName())
			->addFieldDependence(
                $megalvl1dividercolor->getName(),
				$megalvl1dividershow->getName(),
				'1'
            )
			->addFieldDependence(
                $megalvl2dividercolor->getName(),
				$megalvl2dividershow->getName(),
				'1'
            )
			->addFieldDependence(
                $megalvl3dividercolor->getName(),
				$megalvl3dividershow->getName(),
				'1'
            )
			
        );	 
        return parent::_prepareForm();
  }
  public function isJSON($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}
  
}