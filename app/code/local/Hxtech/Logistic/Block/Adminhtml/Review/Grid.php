<?php

class Hxtech_Logistic_Block_Adminhtml_Review_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct() {
        parent::__construct();
        $this->setId('adminhtml_review');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(TRUE);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('logistic/review')->getCollection();

        $adminUserTable = Mage::getResourceSingleton('core/resource')->getTable('admin/user');
        $collection->getSelect()->joinLeft(
            $adminUserTable,
            'main_table.logistic_user_id =' . $adminUserTable . '.user_id',
            array(
                'username',
            )
        );

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('id', array(
            'header' => Mage::helper('logistic')->__('ID'),
            'index' => 'id',
        ));

        $this->addColumn('username', array(
            'header' => Mage::helper('logistic')->__('Logistic Supplier'),
            'index' => 'username',
        ));

        $this->addColumn('nickname', array(
            'header' => Mage::helper('logistic')->__('Nick Name'),
            'index' => 'nickname',
        ));

        $this->addColumn('summary', array(
            'header' => Mage::helper('logistic')->__('Summary'),
            'index' => 'summary',
        ));

        $this->addColumn('number_star', array(
            'header' => Mage::helper('logistic')->__('Number Star'),
            'index' => 'number_star',
        ));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}