<?php

class Hxtech_Document_Block_Adminhtml_Supplier_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct() {
        parent::__construct();
        $this->setId('adminhtml_supplier');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(TRUE);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('is_document_user', 1);
        if(Mage::helper('document')->isDocumentSupplierUser()){
            $documentUserId = Mage::helper('document')->getCurrentAdminUserId();
            $collection->addFieldToFilter('user_id', $documentUserId);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('user_id', array(
            'header' => Mage::helper('document')->__('ID'),
            'index' => 'user_id',
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

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}