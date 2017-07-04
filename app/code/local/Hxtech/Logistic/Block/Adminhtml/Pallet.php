<?php

class Hxtech_Logistic_Block_Adminhtml_Pallet extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct() 
    {
        $this->_controller = 'adminhtml_pallet';
        $this->_blockGroup = 'logistic';
        $this->_headerText = Mage::helper('logistic')->__('Manage Pallets');
        $this->_addButtonLabel = Mage::helper('logistic')->__('Add New Pallet');
        parent::__construct();
    }
}