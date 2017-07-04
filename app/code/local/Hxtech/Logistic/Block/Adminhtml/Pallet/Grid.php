<?php

class Hxtech_Logistic_Block_Adminhtml_Pallet_Grid extends Mage_Adminhtml_Block_Widget_Grid 
{
    public function __construct() 
    {
        parent::__construct();
        $this->setId('adminhtml_logistic');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(TRUE);
    }

    protected function _prepareCollection() 
    {
        $collection = Mage::getModel('logistic/pallet')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() 
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('logistic')->__('ID'),
            'index' => 'id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('logistic')->__('Name'),
            'index' => 'name',
        ));

        $this->addColumn('width', array(
            'header' => Mage::helper('logistic')->__('Width'),
            'index' => 'width',
        ));

        $this->addColumn('length', array(
            'header' => Mage::helper('logistic')->__('Length'),
            'index' => 'length',
        ));

        $this->addColumn('height', array(
            'header' => Mage::helper('logistic')->__('Height'),
            'index' => 'height',
        ));

        $this->addColumn('number_fit_small_container', array(
            'header' => Mage::helper('logistic')->__('Number pallet fit in 20ft container'),
            'index' => 'number_fit_small_container',
        ));

        $this->addColumn('number_fit_large_container', array(
            'header' => Mage::helper('logistic')->__('Number pallet fit in 40ft container'),
            'index' => 'number_fit_large_container',
        ));

        return parent::_prepareColumns();
    }
    
    protected function _prepareMassaction() 
    {
        $this->setMassactionIdField('pallet_id');
        $this->getMassactionBlock()->setFormFieldName('pallet');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('adminhtml')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('adminhtml')->__('Are you sure?'))
        );

        return $this;
    }

    public function getRowUrl($row) 
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}