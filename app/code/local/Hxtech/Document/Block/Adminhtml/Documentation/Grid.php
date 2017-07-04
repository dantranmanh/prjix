<?php

class Hxtech_Document_Block_Adminhtml_Documentation_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct() {
        parent::__construct();
        $this->setId('adminhtml_documentation');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(TRUE);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('document/documentation')->getCollection();

        if(Mage::helper('document')->isAdminUser()){
            $adminUserTable = Mage::getResourceSingleton('core/resource')->getTable('admin/user');
            $collection->getSelect()->joinLeft(
                $adminUserTable,
                'main_table.document_user_id =' . $adminUserTable . '.user_id',
                array(
                    'username',
                )
            );
        }

        if(Mage::helper('document')->isDocumentSupplierUser()){
            $documentationId = Mage::helper('document')->getCurrentAdminUserId();
            $collection->addFieldToFilter('document_user_id', $documentationId);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function  _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareColumns() {
        $store = $this->_getStore();

        $this->addColumn('id', array(
            'header' => Mage::helper('document')->__('Reference ID'),
            'index' => 'id',
        ));

        if(Mage::helper('document')->isAdminUser()){
            $this->addColumn('username', array(
                'header' => Mage::helper('document')->__('Document Supplier'),
                'index' => 'username',
            ));
        }

        $this->addColumn('name_of_service', array(
            'header' => Mage::helper('document')->__('Name of Service'),
            'index' => 'name_of_service',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('document')->__('Status'),
            'align' => 'left',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        // $this->addColumn('document_type', array(
        //     'header' => Mage::helper('document')->__('Document Type'),
        //     'index' => 'document_type',
        //     'type' => 'options',
        //     'options' => Mage::helper('document/field')->getDocumentationGridOptions('document_type')
        // ));

        $this->addColumn('price', array(
            'header' => Mage::helper('document')->__('Price'),
            'index' => 'price',
            'type'  => 'price',
            'currency_code' => $store->getBaseCurrency()->getCode(),
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('document_id');
        $this->getMassactionBlock()->setFormFieldName('document');

        $this->getMassactionBlock()->addItem('delete', array(
                'label' => Mage::helper('adminhtml')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('adminhtml')->__('Are you sure?'))
        );

        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}