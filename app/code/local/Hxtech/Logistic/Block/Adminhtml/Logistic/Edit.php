<?php

class Hxtech_Logistic_Block_Adminhtml_Logistic_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'logistic';
        $this->_controller = 'adminhtml_logistic';

        $logisticId = Mage::app()->getRequest()->getParam('id');

        $this->_updateButton('save', 'label', Mage::helper('logistic')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('logistic')->__('Delete'));

        $this->_addButton('saveandcontinue', array('label' => Mage::helper('adminhtml')->__('Save And Continue Edit'), 'onclick' => 'saveAndContinueEdit()', 'class' => 'save',), -100);

        $this->_addButton('export_order_history_pdf', array(
                'label'     => Mage::helper('logistic')->__('Export History PDF'),
                'onclick'   => "setLocation('".Mage::helper('adminhtml')->getUrl('logistic/adminhtml_logistic/exportOrderHistoryPdf', array('logisticId' => $logisticId))."')",
            ));

        $this->_addButton('send_export_order_history_pdf_email', array(
                'label'     => Mage::helper('logistic')->__('Send Order History Email'),
                'onclick'   => "setLocation('".Mage::helper('adminhtml')->getUrl('logistic/adminhtml_logistic/sendOrderHistoryEmail', array('logisticId' => $logisticId))."')",
            ));

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

        $isAdminUser = Mage::helper('logistic/logistic')->isAdminUser();
        if(!$isAdminUser){
            $this->_removeButton('delete');
        }
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
        if (Mage::registry('logistic_data') && Mage::registry('logistic_data')->getId()) {
            return Mage::helper('logistic')->__("Edit Logistic User '%s'", $this->htmlEscape(Mage::registry('logistic_data')->getUsername()));
        } else {
            return Mage::helper('logistic')->__('Add New Logistic User');
        }
    }
}