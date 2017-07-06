<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product list
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
$base 	= md5('htz&%a'.Mage::getStoreConfig('web/unsecure/base_url',0).'a%&zth');
$dev 	= Mage::getStoreConfig('vendor/settings/devkey');
$live 	= Mage::getStoreConfig('vendor/settings/livekey');
$flag 	= true;
if(Mage::getStoreConfig('vendor/settings/enabled') && ($base==$dev || $base==$live)){
	$flag = false;
}  
if($flag){
	class HTZ_Vendor_Block_Catalog_Product_List
    extends Otnegam_Amastycustom_Block_Catalog_Product_List
	{
	}
} else {
	 
	class HTZ_Vendor_Block_Catalog_Product_List extends Mage_Catalog_Block_Product_Abstract
	{
		/**
		 * Default toolbar block name
		 *
		 * @var string
		 */
		protected $_defaultToolbarBlock = 'catalog/product_list_toolbar';

		/**
		 * Product Collection
		 *
		 * @var Mage_Eav_Model_Entity_Collection_Abstract
		 */
		protected $_productCollection;

		/**
		 * Retrieve loaded category collection
		 *
		 * @return Mage_Eav_Model_Entity_Collection_Abstract
		 */
		protected function _getProductCollection()
		{
			if (is_null($this->_productCollection)) {
				$layer = $this->getLayer();
				/* @var $layer Mage_Catalog_Model_Layer */
				if ($this->getShowRootCategory()) {
					$this->setCategoryId(Mage::app()->getStore()->getRootCategoryId());
				}

				// if this is a product view page
				if (Mage::registry('product')) {
					// get collection of categories this product is associated with
					$categories = Mage::registry('product')->getCategoryCollection()
						->setPage(1, 1)
						->load();
					// if the product is associated with any category
					if ($categories->count()) {
						// show products from this category
						$this->setCategoryId(current($categories->getIterator()));
					}
				}

				$origCategory = null;
				if ($this->getCategoryId()) {
					$category = Mage::getModel('catalog/category')->load($this->getCategoryId());
					if ($category->getId()) {
						$origCategory = $layer->getCurrentCategory();
						$layer->setCurrentCategory($category);
						$this->addModelTags($category);
					}
				}
				$this->_productCollection = $layer->getProductCollection();

				$this->prepareSortableFieldsByCategory($layer->getCurrentCategory());

				if ($origCategory) {
					$layer->setCurrentCategory($origCategory);
				}
			}
            /**
             * Filter all,onsale,instock,new
             */
            if (Mage::getStoreConfig('amastycustom/general/enable') == 1) {
                $this->_amastyExtraFilter($this->_productCollection);
            }
			
			if(Mage::getStoreConfig('vendor/settings/product_active')){
				$eVPIds		= array();
				$customPIds = $this->_productCollection->getAllIds();
								
				$eVPIds = Mage::getModel('catalog/product')->getCollection()
										->addIdFilter($customPIds)
										->addAttributeToSelect('vendor_user')
										->addAttributeToSelect('htz_vendor_product')
										->addAttributeToFilter('htz_vendor_product',array('eq'=>'1'))
										->addAttributeToFilter('vendor_user',array('neq'=>null))
										->getAllIds();
										
				if(count($eVPIds)>0){
					$customPIds = array_diff($customPIds, $eVPIds);
				}
					
				$nEVPIds = Mage::getModel('catalog/product')->getCollection()
										->addIdFilter($customPIds)
										->addAttributeToSelect('vendor_user')
										->addAttributeToSelect('htz_vendor_product')
										->addAttributeToFilter('htz_vendor_product',array('eq'=>'0'))
										->addAttributeToFilter('vendor_user',array('neq'=>null))
										->getAllIds();
										
				if(count($nEVPIds)>0){
					$_customPIds	= array_diff($customPIds, $nEVPIds);
					$eVPIds 		= array_merge($eVPIds, $_customPIds);
				}
				
				return $this->_productCollection->addIdFilter($eVPIds);
			} else {
				return $this->_productCollection;
			}
		}
        protected function _amastyExtraFilter($collection)
        {
            $available = array('all', 'new', 'sale', 'instock');
            $filter = strtolower(Mage::app()->getRequest()->getParam('amf'));
            if (!in_array($filter, $available) || $filter == "all") return $collection;
            if ($filter == "instock") {
                $collection->getSelect()->join('cataloginventory_stock_status', 'cataloginventory_stock_status.product_id = e.entity_id', array('stock_status'));
                $collection->getSelect()->where("`cataloginventory_stock_status`.`stock_status` = 1");
            }
            if ($filter == "sale") {
                $collection->getSelect()->where('`price_index`.`final_price` < `price_index`.`price`');
            }
            if ($filter == "new") {
                /**
                 * Select product created around xdays from now.Defalut is 10.
                 */
                $xday = Mage::getStoreConfig('amastycustom/general/new') ? Mage::getStoreConfig('amastycustom/general/new') : 10;
                $newfrom = date('Y-m-d H:i:s', strtotime("-" . $xday . " days"));
                $collection->getSelect()->where("e.`created_at` > '" . $newfrom . "'");
            }
            return $collection;
        }
		/**
		 * Get catalog layer model
		 *
		 * @return Mage_Catalog_Model_Layer
		 */
		public function getLayer()
		{
			$layer = Mage::registry('current_layer');
			if ($layer) {
				return $layer;
			}
			return Mage::getSingleton('catalog/layer');
		}

		/**
		 * Retrieve loaded category collection
		 *
		 * @return Mage_Eav_Model_Entity_Collection_Abstract
		 */
		public function getLoadedProductCollection()
		{
			return $this->_getProductCollection();
		}

		/**
		 * Retrieve current view mode
		 *
		 * @return string
		 */
		public function getMode()
		{
			return $this->getChild('toolbar')->getCurrentMode();
		}

		/**
		 * Need use as _prepareLayout - but problem in declaring collection from
		 * another block (was problem with search result)
		 */
		protected function _beforeToHtml()
		{
			$toolbar = $this->getToolbarBlock();

			// called prepare sortable parameters
			$collection = $this->_getProductCollection();

			// use sortable parameters
			if ($orders = $this->getAvailableOrders()) {
				$toolbar->setAvailableOrders($orders);
			}
			if ($sort = $this->getSortBy()) {
				$toolbar->setDefaultOrder($sort);
			}
			if ($dir = $this->getDefaultDirection()) {
				$toolbar->setDefaultDirection($dir);
			}
			if ($modes = $this->getModes()) {
				$toolbar->setModes($modes);
			}

			// set collection to toolbar and apply sort
			$toolbar->setCollection($collection);

			$this->setChild('toolbar', $toolbar);
			Mage::dispatchEvent('catalog_block_product_list_collection', array(
				'collection' => $this->_getProductCollection()
			));

			$this->_getProductCollection()->load();

			return parent::_beforeToHtml();
		}

		/**
		 * Retrieve Toolbar block
		 *
		 * @return Mage_Catalog_Block_Product_List_Toolbar
		 */
		public function getToolbarBlock()
		{
			if ($blockName = $this->getToolbarBlockName()) {
				if ($block = $this->getLayout()->getBlock($blockName)) {
					return $block;
				}
			}
			$block = $this->getLayout()->createBlock($this->_defaultToolbarBlock, microtime());
			return $block;
		}

		/**
		 * Retrieve additional blocks html
		 *
		 * @return string
		 */
		public function getAdditionalHtml()
		{
			return $this->getChildHtml('additional');
		}

		/**
		 * Retrieve list toolbar HTML
		 *
		 * @return string
		 */
		public function getToolbarHtml()
		{
			return $this->getChildHtml('toolbar');
		}

		public function setCollection($collection)
		{
			$this->_productCollection = $collection;
			return $this;
		}

		public function addAttribute($code)
		{
			$this->_getProductCollection()->addAttributeToSelect($code);
			return $this;
		}

		public function getPriceBlockTemplate()
		{
			return $this->_getData('price_block_template');
		}

		/**
		 * Retrieve Catalog Config object
		 *
		 * @return Mage_Catalog_Model_Config
		 */
		protected function _getConfig()
		{
			return Mage::getSingleton('catalog/config');
		}

		/**
		 * Prepare Sort By fields from Category Data
		 *
		 * @param Mage_Catalog_Model_Category $category
		 * @return Mage_Catalog_Block_Product_List
		 */
		public function prepareSortableFieldsByCategory($category) {
			if (!$this->getAvailableOrders()) {
				$this->setAvailableOrders($category->getAvailableSortByOptions());
			}
			$availableOrders = $this->getAvailableOrders();
			if (!$this->getSortBy()) {
				if ($categorySortBy = $category->getDefaultSortBy()) {
					if (!$availableOrders) {
						$availableOrders = $this->_getConfig()->getAttributeUsedForSortByArray();
					}
					if (isset($availableOrders[$categorySortBy])) {
						$this->setSortBy($categorySortBy);
					}
				}
			}

			return $this;
		}

		/**
		 * Retrieve block cache tags based on product collection
		 *
		 * @return array
		 */
		public function getCacheTags()
		{
			return array_merge(
				parent::getCacheTags(),
				$this->getItemsTags($this->_getProductCollection())
			);
		}
	}
}