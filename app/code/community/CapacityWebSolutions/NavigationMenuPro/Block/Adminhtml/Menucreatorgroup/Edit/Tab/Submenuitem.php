<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup_Edit_Tab_Submenuitem extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
	    $fieldset = $form->addFieldset('subitems_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Flyout Panel')));
       $fieldset->addField('ddpnl-width','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Width'),
			'name' => 'fly[ddpnl-width]'
		));
		$fieldset->addField('ddpnl-padding','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Padding'),
			'name' => 'fly[ddpnl-padding]',
			'note' => 'Ex: 5px 10px 5px 10px (Top Right Bottom Left)'
		));
		$fieldset->addField('ddpnl-bgcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Background Color'),
			'name' => 'fly[ddpnl-bgcolor]',
			'class' => 'color {required:false}',
		));
		$fieldset->addField('ddpnl-bdwidth','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Border Width'),
			'name' => 'fly[ddpnl-bdwidth]',
			'note' => 'Ex: 2px 4px 4px 2px (Top Right Bottom Left)'
			
		));
		
		$fieldset->addField('ddpnl-bdcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Border Color'),
			'name' => 'fly[ddpnl-bdcolor]',
			'class' => 'color {required:false}',
		));
		$fieldset->addField('ddpnl-corner','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Round Corners'),
			'name' => 'fly[ddpnl-corner]',
			'note' => 'Ex: 5px 10px 5px 10px (Top-Left Top-Right Bottom-Right Bottom-Left)'
		));
		 $fieldset = $form->addFieldset('flysubitem_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Flyout Menu Items')));
		
		$fieldset->addField(
            'ddlinkcolor',
            'text',
            array(
                'name' => 'fly[ddlinkcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'ddlinksize',
            'text',
            array(
                'name' => 'fly[ddlinksize]',
                'label' => Mage::helper('navigationmenupro')->__('Font Size'),
            )
        );
		$fieldset->addField(
            'ddlinkweight',
            'text',
            array(
                'name' => 'fly[ddlinkweight]',
            	'label' => Mage::helper('navigationmenupro')->__('Font Weight'),
			)
        );
		$fieldset->addField(
            'ddlinkcase',
            'select',
            array(
                'name' => 'fly[ddlinkcase]',
                'label' => Mage::helper('navigationmenupro')->__('Font Transform'),
				'values' => Mage::helper('navigationmenupro')->getFontTransform() 
            )
        );
		
		$fieldset->addField(
            'ddlinkbgcolor',
            'text',
            array(
                'name' => 'fly[ddlinkbgcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'ddlinkpadding',
            'text',
            array(
                'name' => 'fly[ddlinkpadding]',
                'label' => Mage::helper('navigationmenupro')->__('Padding'),
				'note' => 'Ex : Top Right Bottom Left',
            )
        );
		
		$dddividershow = $fieldset->addField(
            'ddshowdivider',
            'select',
            array(
                'name' => 'fly[ddshowdivider]',
                'label' => Mage::helper('navigationmenupro')->__('Show Divider'),
                'title' => __('Show Divider'),
                'values' =>Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            )
        );
		
		$dddividercolor = $fieldset->addField(
            'ddlinkdvcolor',
            'text',
            array(
                'name' => 'fly[ddlinkdvcolor]',
                'label' => Mage::helper('navigationmenupro')->__('Divider Color'),
                'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('flysubitemitem_hover', array('legend' => Mage::helper('navigationmenupro')->__('Flyout Menu Items on Hover')));
		
		$fieldset->addField(
            'ddlinkcolorh',
            'text',
            array(
                'name' => 'fly[ddlinkcolorh]',
                'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'ddlinkbgcolorh',
            'text',
            array(
                'name' => 'fly[ddlinkbgcolorh]',
                'label' => Mage::helper('navigationmenupro')->__('Background Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset = $form->addFieldset('flysubitemitem_active', array('legend' => Mage::helper('navigationmenupro')->__('Flyout Menu Items on Active')));
		
		$fieldset->addField(
            'ddlinkcolora',
            'text',
            array(
                'name' => 'fly[ddlinkcolora]',
                 'label' => Mage::helper('navigationmenupro')->__('Font Color'),
				'class' => 'color {required:false}'
            )
        );
		$fieldset->addField(
            'ddlinkbgcolora',
            'text',
            array(
                'name' => 'fly[ddlinkbgcolora]',
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
		/* Flyout Panel  Options*/
		$data['ddpnl-width']='200px';
		$data['ddpnl-padding']='0px 0px 0px 0px';
		$data['ddpnl-bgcolor']='#FFFFFF';
		$data['ddpnl-bdwidth']='5px 0px 0px 0px';
		$data['ddpnl-bdcolor']='#FE5656';
		$data['ddpnl-corner']='0px 5px 5px 5px';
		/*  Flyout Menu Items Options*/
		$data['ddlinkcolor']='#333333';
		$data['ddlinksize']='14px';
		$data['ddlinkweight']='700';
		$data['ddlinkcase']='inherit';
		$data['ddlinkbgcolor']='#F3F3F3';
		$data['ddlinkpadding']='8px 10px 8px 10px';
		$data['ddshowdivider']='1';
		$data['ddlinkdvcolor']='#DDDDDD';
		/*  Flyout Menu Items on Hover Options*/
		$data['ddlinkcolorh']='#FE5656';
		$data['ddlinkbgcolorh']='#EEEEEE';
		/*  Flyout Menu Items on Active Options*/
		$data['ddlinkcolora']='#FE5656';
		$data['ddlinkbgcolora']='#FFFFFF';
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
          ->addFieldMap($dddividershow->getHtmlId(), $dddividershow->getName())
			->addFieldMap($dddividercolor->getHtmlId(), $dddividercolor->getName())
			->addFieldDependence(
                $dddividercolor->getName(),
				$dddividershow->getName(),
				'1'
            )
			
        );	 
        return parent::_prepareForm();
  }
  public function isJSON($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}
  
}