<?php

class Hxtech_Document_Block_Adminhtml_Supplier extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_controller = 'adminhtml_supplier';
        $this->_blockGroup = 'document';
        $this->_headerText = Mage::helper('document')->__('Manage Document Supplier');
        $this->_addButtonLabel = Mage::helper('document')->__('Add New Document Supplier');
        parent::__construct();

        if(Mage::helper('document')->isDocumentSupplierUser()){
        	$this->_removeButton('add');
        }
    }
}