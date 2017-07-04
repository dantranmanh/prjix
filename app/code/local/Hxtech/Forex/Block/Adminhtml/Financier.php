<?php

class Hxtech_Forex_Block_Adminhtml_Financier extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_controller = 'adminhtml_financier';
        $this->_blockGroup = 'forex';
        $this->_headerText = Mage::helper('forex')->__('Manage Financier');
        $this->_addButtonLabel = Mage::helper('forex')->__('Add New Financier');
        parent::__construct();
    }
}