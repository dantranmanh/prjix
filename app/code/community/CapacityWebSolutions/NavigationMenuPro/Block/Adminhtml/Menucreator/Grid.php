<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreator_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
  
      parent::__construct();
      $this->setId('menucreatorGrid');
      $this->setDefaultSort('menu_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection($store)
  {		
      $collection = Mage::getModel('navigationmenupro/menucreator')->getCollection();
	  $this->setCollection($collection);
	  return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  
	$permission = Mage::helper('navigationmenupro')->getPermissionforgrid();
	$menu_group = Mage::getModel('navigationmenupro/menucreator')->getMenuGroupdetails();
  	
	$this->addColumn('menu_id', array(
          'header'    => Mage::helper('navigationmenupro')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'menu_id',
      ));
	
	  $this->addColumn('group_id',
		array(
			'header'=> Mage::helper('navigationmenupro')->__('Group ID Render'),
			'index' => 'group_id',
			));
			
			$this->addColumn ('group_id',array (
				'header' => Mage::helper ('navigationmenupro')->__ ('Menu Group'),
				'align' => 'left',
				'width' => '80px',
				'index' => 'group_id',
				'type' => 'options',
				'options' => $menu_group
		) );
			
			
	  
		$this->addColumn('title', array(
			'header'    => Mage::helper('navigationmenupro')->__('Title'),
			 'align'     =>'left',
			 'index'     => 'title',
      ));
	  
	 	$this->addColumn ('type', array (
				'header' => Mage::helper ('navigationmenupro')->__ ('Menu Type'),
				'align' => 'left',
				'width' => '80px',
				'index' => 'type',
				'type' => 'options',
				'options' => array (
						1 => 'CMS Page',
						2 => 'Category Page',
						3 => 'Static Block',
						4 => 'Product Page',
						5 => 'Custom Url',
						6 => 'Alias [href=#]',
						'account' => 'My Account',
						'cart' => 'My Cart',
						'wishlist' => 'My Wishlist',
						'checkout' => 'Checkout',
						'login' => 'Login',
						'logout' => 'Logout',
						'register' => 'Register',
						'contact' => 'Contact Us'
				) 
		) );
	 
	  $this->addColumn('permission', array(
			'header'    => Mage::helper('navigationmenupro')->__('Access Permission'),
			 'align'     =>'left',
			 'index'     => 'permission',
			 'align' => 'left',
				'width' => '80px',
				'index' => 'permission',
				'type' => 'options',
			 'options' => $permission
      ));
	
 
	  $this->addColumn ('status', array (
				'header' => Mage::helper ('navigationmenupro')->__ ('Menu Status'),
				'align' => 'left',
				'width' => '80px',
				'index' => 'status',
				'type' => 'options',
				'options' => Mage::getModel('navigationmenupro/status')->getOptionArray() ) );
	$this->addColumn('action',
            array(
                'header'    =>  Mage::helper('navigationmenupro')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('navigationmenupro')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		return parent::_prepareColumns();
  }

    protected function _prepareMassaction(){
        $this->setMassactionIdField('menu_id');
        $this->getMassactionBlock()->setFormFieldName('navigationmenupro');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('navigationmenupro')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('navigationmenupro')->__('Are you sure?')
        ));

        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }
 

}