<?php

class Hxtech_Logistic_Block_Adminhtml_Review_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('review_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('logistic')->__('Review Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('review_info', array(
            'label' => Mage::helper('logistic')->__('Review Information'),
            'title' => Mage::helper('logistic')->__('Review Information'),
            'content' => $this->getLayout()->createBlock('logistic/adminhtml_review_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}