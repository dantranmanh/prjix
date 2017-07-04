<?php

class Hxtech_Document_Block_Adminhtml_Documentation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'document';
        $this->_controller = 'adminhtml_documentation';

        $this->_updateButton('save', 'label', Mage::helper('document')->__('Save Documentation'));
        $this->_updateButton('delete', 'label', Mage::helper('document')->__('Delete Documentation'));

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
        if (Mage::registry('documentation_data') && Mage::registry('documentation_data')->getId()) {
            return Mage::helper('document')->__("Edit '%s'", $this->htmlEscape(Mage::registry('documentation_data')->getNameOfService()));
        } else {
            return Mage::helper('document')->__('Add New Documentation');
        }
    }
}