<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup_Edit_Tab_Suboptions extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
	    $fieldset = $form->addFieldset('megaitem_form_color', array('legend' => Mage::helper('navigationmenupro')->__('First Level Items')));
		
		$fieldset->addField(
            'sublvl1color',
            'text',
            array(
                'name' => 'sub[sublvl1color]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl1size',
            'text',
            array(
                'name' => 'sub[sublvl1size]',
                'label' => Mage::helper('navigationmenupro')->__('Font Size'),
            )
        );
		$fieldset->addField(
            'sublvl1weight',
            'text',
            array(
                'name' => 'sub[sublvl1weight]',
                'label' => Mage::helper('navigationmenupro')->__('Font Weight'),
				
            )
        );
		$fieldset->addField(
            'sublvl1case',
            'select',
            array(
                'name' => 'sub[sublvl1case]',
                'label' => Mage::helper('navigationmenupro')->__('Font Transform'),
				'values' =>Mage::helper('navigationmenupro')->getFontTransform()
				
            )
        );
		
		$fieldset->addField(
            'sublvl1bgcolor',
            'text',
            array(
                'name' => 'sub[sublvl1bgcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl1padding',
            'text',
            array(
                'name' => 'sub[sublvl1padding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		 $subsdividershow = $fieldset->addField(
            'sublvl1showdivider',
            'select',
            array(
                'name' => 'sub[sublvl1showdivider]',
                'label' => Mage::helper('navigationmenupro')->__('Show Divider'),
                'title' => __('Show Divider'),
                'values' =>Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            )
        );
		
		$subdividercolor = $fieldset->addField(
            'sublvl1dvcolor',
            'text',
            array(
                'name' => 'sub[sublvl1dvcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Divider Color'),
                'class' => 'color {required:false}'
            )
        );
		
		 
		$fieldset = $form->addFieldset('mgfrstitem_hover', array('legend' => Mage::helper('navigationmenupro')->__('First Level Items on Hover')));
		
		$fieldset->addField(
            'sublvl1colorh',
            'text',
            array(
                'name' => 'sub[sublvl1colorh]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl1bgcolorh',
            'text',
            array(
                'name' => 'sub[sublvl1bgcolorh]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('mgfrstitem_active', array('legend' => Mage::helper('navigationmenupro')->__('First Level Items on Active')));
		
		$fieldset->addField(
            'sublvl1colora',
            'text',
            array(
                'name' => 'sub[sublvl1colora]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl1bgcolora',
            'text',
            array(
                'name' => 'sub[sublvl1bgcolora]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('megaseconditem_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Second Level Items')));
		
		$fieldset->addField(
            'sublvl2color',
            'text',
            array(
                'name' => 'sub[sublvl2color]',
				'label' => Mage::helper('navigationmenupro')->__('Font Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl2size',
            'text',
            array(
                'name' => 'sub[sublvl2size]',
                'label' => Mage::helper('navigationmenupro')->__('Font Size'),
            )
        );
		$fieldset->addField(
            'sublvl2weight',
            'text',
            array(
                'name' => 'sub[sublvl2weight]',
                'label' => Mage::helper('navigationmenupro')->__('Font Weight'),
				
            )
        );
		$fieldset->addField(
            'sublvl2case',
            'select',
            array(
                'name' => 'sub[sublvl2case]',
                'label' => Mage::helper('navigationmenupro')->__('Font Transform'),
				'values' =>Mage::helper('navigationmenupro')->getFontTransform() 
				
            )
        );
		$fieldset->addField(
            'sublvl2bgcolor',
            'text',
            array(
                'name' => 'sub[sublvl2bgcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl2padding',
            'text',
            array(
                'name' => 'sub[sublvl2padding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		$fieldset->addField(
            'sublvl2dvcolor',
            'text',
            array(
                'name' => 'sub[sublvl2dvcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Divider Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('mgsecitem_hover', array('legend' => Mage::helper('navigationmenupro')->__('Second Level Items on Hover')));
		
		$fieldset->addField(
            'sublvl2colorh',
            'text',
            array(
                'name' => 'sub[sublvl2colorh]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl2bgcolorh',
            'text',
            array(
                'name' => 'sub[sublvl2bgcolorh]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('mgsecitem_active', array('legend' => Mage::helper('navigationmenupro')->__('Second Level Items on Active')));
		
		$fieldset->addField(
            'sublvl2colora',
            'text',
            array(
                'name' => 'sub[sublvl2colora]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl2bgcolora',
            'text',
            array(
                'name' => 'sub[sublvl2bgcolora]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('megathirditem_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Third Level Items')));
		
		$fieldset->addField(
            'sublvl3color',
            'text',
            array(
                'name' => 'sub[sublvl3color]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl3size',
            'text',
            array(
                'name' => 'sub[sublvl3size]',
                'label' => Mage::helper('navigationmenupro')->__('Font Size'),
            )
        );
		$fieldset->addField(
            'sublvl3weight',
            'text',
            array(
                'name' => 'sub[sublvl3weight]',
                'label' => Mage::helper('navigationmenupro')->__('Font Weight'),
				
            )
        );
		$fieldset->addField(
            'sublvl3case',
            'select',
            array(
                'name' => 'sub[sublvl3case]',
                'label' => Mage::helper('navigationmenupro')->__('Font Transform'),
				'values' => Mage::helper('navigationmenupro')->getFontTransform() 
            )
        );
		$fieldset->addField(
            'sublvl3bgcolor',
            'text',
            array(
                'name' => 'sub[sublvl3bgcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl3padding',
            'text',
            array(
                'name' => 'sub[sublvl3padding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)',
            )
        );
		$fieldset->addField(
            'sublvl3dvcolor',
            'text',
            array(
                'name' => 'sub[sublvl3dvcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Divider Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('mgthirditem_hover', array('legend' => Mage::helper('navigationmenupro')->__('Third Level Items on Hover')));
		
		$fieldset->addField(
            'sublvl3colorh',
            'text',
            array(
                'name' => 'sub[sublvl3colorh]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl3bgcolorh',
            'text',
            array(
                'name' => 'sub[sublvl3bgcolorh]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('mgthirditem_active', array('legend' => Mage::helper('navigationmenupro')->__('Third Level Items on Active')));
		
		$fieldset->addField(
            'sublvl3colora',
            'text',
            array(
                'name' => 'sub[sublvl3colora]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'sublvl3bgcolora',
            'text',
            array(
                'name' => 'sub[sublvl3bgcolora]',
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
			/* First Level Items Options*/
		$data['sublvl1color']='#122736';
		$data['sublvl1size']='15px';
		$data['sublvl1weight']='400';
		$data['sublvl1case']='capitalize';
		$data['sublvl1bgcolor']='#E8E8E8';
		$data['sublvl1padding']='8px 8px 8px 20px';
		$data['sublvl1showdivider']='1';
		$data['sublvl1dvcolor']='#DCDCDC';
		/* First Level Items on Hover  Options*/
		$data['sublvl1colorh']='#FFFFFF';
		$data['sublvl1bgcolorh']='#FE5656';
		/* First Level Items on Active  Options*/
		$data['sublvl1colora']='#FE5656';
		$data['sublvl1bgcolora']='#E8E8E8';
			/* Second Level Items Options*/
		$data['sublvl2color']='#122736';
		$data['sublvl2size']='14px';
		$data['sublvl2weight']='400';
		$data['sublvl2case']='inherit';
		$data['sublvl2bgcolor']='#E0E0E0';
		$data['sublvl2padding']='7px 8px 7px 25px';
		$data['sublvl2dvcolor']='#D5D5D5';
		/* Second Level Items on Hover  Options*/
		$data['sublvl2colorh']='#FFFFFF';
		$data['sublvl2bgcolorh']='#FE5656';
		/* Second Level Items on Active  Options*/
		$data['sublvl2colora']='#FE5656';
		$data['sublvl2bgcolora']='#E0E0E0';
			/* Third Level Items Options*/
		$data['sublvl3color']='#122736';
		$data['sublvl3size']='14px';
		$data['sublvl3weight']='400';
		$data['sublvl3case']='capitalize';
		$data['sublvl3bgcolor']='#D9D9D9';
		$data['sublvl3padding']='6px 8px 6px 30px';
		$data['sublvl3dvcolor']='#CCCCCC';
		/* Third Level Items on Hover  Options*/
		$data['sublvl3colorh']='#FFFFFF';
		$data['sublvl3bgcolorh']='#FE5656';
		/* Third Level Items on Active  Options*/
		$data['sublvl3colora']='#FE5656';
		$data['sublvl3bgcolora']='#D9D9D9';
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
           ->addFieldMap($subsdividershow->getHtmlId(), $subsdividershow->getName())
			->addFieldMap($subdividercolor->getHtmlId(), $subdividercolor->getName())
			->addFieldDependence(
                $subdividercolor->getName(),
				$subsdividershow->getName(),
				'1'
            )
			
        );	 
        return parent::_prepareForm();
  }
  public function isJSON($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}
  
}