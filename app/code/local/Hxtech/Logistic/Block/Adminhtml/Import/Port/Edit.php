<?php

class Hxtech_Logistic_Block_Adminhtml_Import_Port_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'logistic';
        $this->_controller = 'adminhtml_review';

        $this->_addButton('saveandcontinue', array('label' => Mage::helper('adminhtml')->__('Save And Continue Edit'), 'onclick' => 'saveAndContinueEdit()', 'class' => 'save',), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('port_data') && Mage::registry('port_data')->getId()) {
            return Mage::helper('logistic')->__("Edit Port");
        } else {
            return Mage::helper('logistic')->__('Add New Port');
        }
    }
}