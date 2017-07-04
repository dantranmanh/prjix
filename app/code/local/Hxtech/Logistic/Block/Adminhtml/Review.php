<?php

class Hxtech_Logistic_Block_Adminhtml_Review extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_controller = 'adminhtml_review';
        $this->_blockGroup = 'logistic';
        $this->_headerText = Mage::helper('logistic')->__('Logistic Review');
        parent::__construct();
        $this->_removeButton('add');
    }
}