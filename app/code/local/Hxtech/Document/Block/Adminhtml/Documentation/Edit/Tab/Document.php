<?php

class Hxtech_Document_Block_Adminhtml_Documentation_Edit_Tab_Document extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('list_document_suppplier');
        $this->setDefaultSort('id');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('is_document_user', 1);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('user_id', array(
            'header_css_class'  => 'a-center',
            'type'              => 'radio',
            'html_name'        => 'selected_document[]',
            'value'            => $this->_getSelectedDocumentSupplier(),
            'align'             => 'center',
            'index'             => 'user_id'
        ));

        $this->addColumn('email', array(
            'header' => Mage::helper('document')->__('Email'),
            'index' => 'email',
        ));

        $this->addColumn('username', array(
            'header' => Mage::helper('document')->__('User Name'),
            'index' => 'username',
        ));

        $this->addColumn('firstname', array(
            'header' => Mage::helper('document')->__('First Name'),
            'index' => 'firstname',
        ));

        $this->addColumn('lastname', array(
            'header' => Mage::helper('document')->__('Last Name'),
            'index' => 'lastname',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return false;
    }

    protected function _getSelectedDocumentSupplier()
    {
        $documentId = $this->getSelectedDocumentSupplier();
        return $documentId;
    }


    public function getSelectedDocumentSupplier()
    {
        $documentationId = $this->getRequest()->getParam('id');
        $currentDocumentation = Mage::getModel('document/documentation')->load($documentationId);
        $documentId = $currentDocumentation->getDocumentUserId();
        return $documentId;
    }
}