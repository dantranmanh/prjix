<?php

class Hxtech_Logistic_Block_Adminhtml_Import_Port_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('port_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('logistic')->__('Port Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('port_info', array(
            'label' => Mage::helper('logistic')->__('Port Information'),
            'title' => Mage::helper('logistic')->__('Port Information'),
            'content' => $this->getLayout()->createBlock('logistic/adminhtml_import_port_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}