<?php

class Hxtech_Logistic_Block_Adminhtml_Shippingrate extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_controller = 'adminhtml_shippingrate';
        $this->_blockGroup = 'logistic';
        $this->_headerText = Mage::helper('logistic')->__('Manage Shipping Rate');
        $this->_addButtonLabel = Mage::helper('logistic')->__('Add New Shipping Rate');
        parent::__construct();
    }
}