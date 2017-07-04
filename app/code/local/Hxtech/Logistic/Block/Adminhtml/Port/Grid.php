<?php

class Hxtech_Logistic_Block_Adminhtml_Port_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct() {
        parent::__construct();
        $this->setId('adminhtml_review');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(TRUE);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('logistic/port')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('id', array(
            'header' => Mage::helper('logistic')->__('ID'),
            'index' => 'id',
        ));

        $this->addColumn('country_code', array(
            'header' => Mage::helper('logistic')->__('Country Code'),
            'type'  => 'country',
            'index' => 'country_code',
        ));

        $this->addColumn('port', array(
            'header' => Mage::helper('logistic')->__('Port'),
            'index' => 'port',
        ));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}