<?php

class Hxtech_Logistic_Block_Adminhtml_Shippingrate_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'logistic';
        $this->_controller = 'adminhtml_shippingrate';

        $this->_updateButton('save', 'label', Mage::helper('logistic')->__('Save Shipping Rate'));
        $this->_updateButton('delete', 'label', Mage::helper('logistic')->__('Delete Shipping Rate'));

        $this->_addButton('saveandcontinue', array('label' => Mage::helper('adminhtml')->__('Save And Continue Edit'), 'onclick' => 'saveAndContinueEdit()', 'class' => 'save',), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('award_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'award_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'award_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('shippingrate_data') && Mage::registry('shippingrate_data')->getId()) {
            return Mage::helper('logistic')->__("Edit '%s'", $this->htmlEscape(Mage::registry('shippingrate_data')->getNameOfService()));
        } else {
            return Mage::helper('logistic')->__('Add New Shipping Rate');
        }
    }
}