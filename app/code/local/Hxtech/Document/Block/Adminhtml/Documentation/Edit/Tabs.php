<?php

class Hxtech_Document_Block_Adminhtml_Documentation_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('documentation_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('document')->__('Documentation Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('documentation_info', array(
            'label' => Mage::helper('document')->__('Documentation Information'),
            'title' => Mage::helper('document')->__('Documentation Information'),
            'content' => $this->getLayout()->createBlock('document/adminhtml_documentation_edit_tab_form')->toHtml(),
        ));

        if(Mage::helper('document')->isAdminUser()){
            $this->addTab('document_provider', array(
                'label' => Mage::helper('document')->__('Document Provider'),
                'title' => Mage::helper('document')->__('Document Provider'),
                'url' => $this->getUrl('document/adminhtml_documentation/documentTab', array('_current' => true)),
                'class' => 'ajax',
            ));
        }

        return parent::_beforeToHtml();
    }
}