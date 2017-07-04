<?php

class Hxtech_Document_Block_Adminhtml_Documentation extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_controller = 'adminhtml_documentation';
        $this->_blockGroup = 'document';
        $this->_headerText = Mage::helper('document')->__('Manage Documentation');
        $this->_addButtonLabel = Mage::helper('document')->__('Add New Rate');
        parent::__construct();
    }
}