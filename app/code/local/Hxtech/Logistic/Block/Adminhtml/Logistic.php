<?php

class Hxtech_Logistic_Block_Adminhtml_Logistic extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_controller = 'adminhtml_logistic';
        $this->_blockGroup = 'logistic';
        $this->_headerText = Mage::helper('logistic')->__('Manage Logistic Provider');
        $this->_addButtonLabel = Mage::helper('logistic')->__('Add New Logistic Provider');
        parent::__construct();

        if(!Mage::helper('logistic/logistic')->isAdminUser()){
        	$this->_removeButton('add');
        }
    }
}