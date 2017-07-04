<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
	  parent::__construct();
      $this->setId('menucreatorgroupGrid');
      $this->setDefaultSort('group_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{		
      $collection = Mage::getModel('navigationmenupro/menucreatorgroup')->getCollection();
		$this->setCollection($collection);
      return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
	$this->addColumn ('group_id', array (
				'header' => Mage::helper ('navigationmenupro')->__ ('Group ID'),
				'align' => 'left',
				'width' => '50px',
				'index' => 'group_id' 
		) );
		
		$this->addColumn ('title', array (
				'header' => Mage::helper ('navigationmenupro')->__ ('Group Title'),
				'align' => 'left',
				'index' => 'title' 
		) );
		
		$this->addColumn ('position', array (
				'header' => Mage::helper ('navigationmenupro')->__ ('Align'),
				'align' => 'left',
				'width' => '80px',
				'index' => 'position',
				'type' => 'options',
				'options' => array (
						'horizontal' => 'Horizontal',
						'vertical' => 'Vertical' 
				) 
		) );
		$this->addColumn ('menutype', array (
				'header' => Mage::helper ('navigationmenupro')->__ ('Menu Type'),
				'align' => 'left',
				'width' => '80px',
				'index' => 'menutype',
				'type' => 'options',
				'options' => array (
						'mega-menu' => 'Mega Menu',
						'smart-expand' => 'Smart Expand',
						'always-expand' => 'Always Expand',
						'list-item' => 'List Item',
				) 
		) );
		$this->addColumn ('level', array (
				'header' => Mage::helper ('navigationmenupro')->__ ('Menu Level'),
				'align' => 'left',
				'width' => '80px',
				'index' => 'level',
				'type' => 'options',
				'options' => array (
						'0' => 'Only Root Level',
						'1' => 'One Level',
						'2' => 'Second Level',
						'3' => 'Third Level',
						'4' => 'Fourth Level',
						'5' => 'Fifth Level',
				) 
		) );
		
		$this->addColumn ( 'status', array (
				'header' => Mage::helper ('navigationmenupro')->__ ('Status'),
				'align' => 'left',
				'width' => '80px',
				'index' => 'status',
				'type' => 'options',
				'options' => array (
						1 => 'Enabled',
						2 => 'Disabled' 
				) 
		) );
		
		$this->addColumn ( 'action', array (
				'header' => Mage::helper ('navigationmenupro')->__ ( 'Action' ),
				'width' => '100',
				'type' => 'action',
				'getter' => 'getId',
				'actions' => array (
						array (
								'caption' => Mage::helper ( 'navigationmenupro' )->__ ( 'Edit' ),
								'url' => array (
										'base' => '*/*/edit' 
								),
								'field' => 'id' 
						) 
				),
				'filter' => false,
				'sortable' => false,
				'index' => 'stores',
				'is_system' => true 
		) );
		return parent::_prepareColumns();
	}

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('group_id');
        $this->getMassactionBlock()->setFormFieldName('navigationmenupro');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('navigationmenupro')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('navigationmenupro')->__('Are you sure?')
        ));
		$menu_level = Mage::helper('navigationmenupro')->getmassMenuLevel();
		array_unshift($menu_level, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('level', array(
             'label'=> Mage::helper('navigationmenupro')->__('Change Menu Level'),
             'url'  => $this->getUrl('*/*/massLevel', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'level',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('navigationmenupro')->__('Menu Level'),
                         'values' => $menu_level
        )
        )
        ));
		$status = Mage::getModel('navigationmenupro/status')->getOptionArray();
		array_unshift($status, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('navigationmenupro')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('navigationmenupro')->__('Status'),
                         'values' => $status
        )
        )
        ));

        
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}