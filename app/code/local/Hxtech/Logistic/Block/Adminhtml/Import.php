<?php

class Hxtech_Logistic_Block_Adminhtml_Import extends Mage_Adminhtml_Block_Widget_Form_Container {
    public function __construct() {
    	parent::__construct();
	    $this->_updateButton('save', 'label', Mage::helper('logistic')->__('Import'));
	    $this->_removeButton('delete');
	    $this->_removeButton('back');

	    $this->_blockGroup = 'logistic';
	    $this->_controller = 'adminhtml';
	    $this->_mode = 'import';
    }

    public function getHeaderText() {
	    return Mage::helper('logistic')->__('Import Shipping Rate');
    }
}