<?php

class Hxtech_Logistic_Block_Adminhtml_Shippingrate_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('shippingrate_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('logistic')->__('Shipping Rate Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('shippingrate_info', array(
            'label' => Mage::helper('logistic')->__('Shipping Rate Information'),
            'title' => Mage::helper('logistic')->__('Shipping Rate Information'),
            'content' => $this->getLayout()->createBlock('logistic/adminhtml_shippingrate_edit_tab_form')->toHtml(),
        ));

        if(Mage::helper('logistic/logistic')->isAdminUser()){
            $this->addTab('logistic_provider', array(
                'label' => Mage::helper('logistic')->__('Logistic Provider'),
                'title' => Mage::helper('logistic')->__('Logistic Provider'),
                'url' => $this->getUrl('logistic/adminhtml_shippingrate/logisticTab', array('_current' => true)),
                'class' => 'ajax',
            ));
        }

        return parent::_beforeToHtml();
    }
}