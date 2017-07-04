<?php

class Hxtech_Forex_Block_Adminhtml_Financier_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'forex';
        $this->_controller = 'adminhtml_financier';

        $this->_updateButton('save', 'label', Mage::helper('logistic')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('logistic')->__('Delete'));

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

    protected function _prepareLayout() 
    { 
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true); 
        } 
        parent::_prepareLayout(); 
    }

    public function getHeaderText()
    {
        if (Mage::registry('financier_data') && Mage::registry('financier_data')->getId()) {
            return Mage::helper('forex')->__("Edit Financier '%s'", $this->htmlEscape(Mage::registry('financier_data')->getName()));
        } else {
            return Mage::helper('forex')->__('Add New Financier');
        }
    }
}