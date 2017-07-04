<?php

class Hxtech_Logistic_Block_Adminhtml_Pallet_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'logistic';
        $this->_controller = 'adminhtml_pallet';

        $this->_updateButton('save', 'label', Mage::helper('logistic')->__('Save Pallet'));
        $this->_updateButton('delete', 'label', Mage::helper('logistic')->__('Delete Pallet'));

        $this->_addButton('saveandcontinue', array('label' => Mage::helper('adminhtml')->__('Save And Continue Edit'), 'onclick' => 'saveAndContinueEdit()', 'class' => 'save',), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('pallet_data') && Mage::registry('pallet_data')->getId()) {
            return Mage::helper('logistic')->__("Edit '%s'", $this->htmlEscape(Mage::registry('pallet_data')->getName()));
        } else {
            return Mage::helper('logistic')->__('Add New Pallet');
        }
    }
}