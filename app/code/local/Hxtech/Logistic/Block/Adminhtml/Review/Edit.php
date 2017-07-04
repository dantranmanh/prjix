<?php

class Hxtech_Logistic_Block_Adminhtml_Review_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'logistic';
        $this->_controller = 'adminhtml_review';

        $this->_addButton('saveandcontinue', array('label' => Mage::helper('adminhtml')->__('Save And Continue Edit'), 'onclick' => 'saveAndContinueEdit()', 'class' => 'save',), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('review') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'review');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'review');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('review_data') && Mage::registry('review_data')->getId()) {
            return Mage::helper('logistic')->__("Edit Review");
        } else {
            return Mage::helper('logistic')->__('Add New Review');
        }
    }
}