<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreator_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'navigationmenupro';
        $this->_controller = 'adminhtml_menucreator';
        $this->_updateButton('save', 'label', Mage::helper('navigationmenupro')->__('Save Menu Item'));
        $this->_updateButton('delete', 'label', Mage::helper('navigationmenupro')->__('Delete Menu Item'));
		 $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save Menu Item And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
            ), -100);
      
	  
	  $current_menu_id = $this->getRequest()->getParam('id');
	  $group_id = $this->getRequest()->getParam('group_id');
	  $parent_id = $this->getRequest()->getParam('parent_id');
		if(($current_menu_id == '') && ($group_id == '') && ($parent_id == ''))
		{
		$url = Mage::helper('adminhtml')->getUrl('adminhtml/menudata/parent');
		}else if($current_menu_id != '')
		{
		$url = Mage::helper("adminhtml")->getUrl("adminhtml/menudata/parent/",array("current_menu"=> $current_menu_id));
		}else if(($group_id != '') && ($parent_id != ''))
		{
		$url = Mage::helper("adminhtml")->getUrl("adminhtml/menudata/addsubparent/",array("current_menu"=> $parent_id));
		}
	  
		$this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('menucreatorgroup_comment') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'menucreatorgroup_comment');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'menucreatorgroup_comment');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
			onload = function()
			{
			
			var menu_type = document.getElementById('type').value;
			var group_id = document.getElementById('group_id').value;
			var url = '". $url. "';
			parent_item(group_id,url);
			var groupid = '". $group_id. "';
			var parentid = '". $parent_id. "';
			if((groupid != '') && (parentid != ''))
			{
			parent_item(groupid,url);
			document.getElementById('group_id').value = '". $group_id. "';
			}
			}
        ";
	
	    }

    public function getHeaderText()
    {	
		if( Mage::registry('menucreator_data') && Mage::registry('menucreator_data')->getGroupId() ) {
            return Mage::helper('navigationmenupro')->__("Edit Item '%s' Information", $this->htmlEscape(Mage::registry('menucreator_data')->getTitle()));
        } else {
            return Mage::helper('navigationmenupro')->__('Add Menu Item');
        }
    }
}