<?php

class Hxtech_Document_Block_Adminhtml_Supplier_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'document';
        $this->_controller = 'adminhtml_supplier';

        $documentId = Mage::app()->getRequest()->getParam('id');

        $this->_updateButton('save', 'label', Mage::helper('document')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('document')->__('Delete'));

        $this->_addButton('saveandcontinue', array('label' => Mage::helper('adminhtml')->__('Save And Continue Edit'), 'onclick' => 'saveAndContinueEdit()', 'class' => 'save',), -100);

        $this->_addButton('export_order_history_pdf', array(
                'label'     => Mage::helper('document')->__('Export History PDF'),
                'onclick'   => "setLocation('".Mage::helper('adminhtml')->getUrl('document/adminhtml_supplier/exportOrderHistoryPdf', array('documentId' => $documentId))."')",
            ));

        $this->_addButton('send_export_order_history_pdf_email', array(
                'label'     => Mage::helper('logistic')->__('Send Order History Email'),
                'onclick'   => "setLocation('".Mage::helper('adminhtml')->getUrl('document/adminhtml_supplier/sendOrderHistoryEmail', array('documentId' => $documentId))."')",
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

        $isAdminUser = Mage::helper('document')->isAdminUser();
        if(!$isAdminUser){
            $this->_removeButton('delete');
        }
    }

    public function getHeaderText()
    {
        if (Mage::registry('document_supplier_data') && Mage::registry('document_supplier_data')->getId()) {
            return Mage::helper('document')->__("Edit Document Supplier User '%s'", $this->htmlEscape(Mage::registry('document_supplier_data')->getUsername()));
        } else {
            return Mage::helper('document')->__('Add New Document Supplier User');
        }
    }
}