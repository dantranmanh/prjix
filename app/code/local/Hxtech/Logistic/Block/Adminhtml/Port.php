<?php

class Hxtech_Logistic_Block_Adminhtml_Port extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_controller = 'adminhtml_port';
        $this->_blockGroup = 'logistic';
        $this->_headerText = Mage::helper('logistic')->__('Port Management');
        parent::__construct();
        $this->_removeButton('add');
    }
}