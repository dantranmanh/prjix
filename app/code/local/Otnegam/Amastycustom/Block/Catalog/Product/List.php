<?php

class Otnegam_Amastycustom_Block_Catalog_Product_List extends Mage_Catalog_Block_Product_List
{
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

            if (Mage::registry('product')) {
                /** @var Mage_Catalog_Model_Resource_Category_Collection $categories */
                $categories = Mage::registry('product')->getCategoryCollection()
                    ->setPage(1, 1)
                    ->load();
                if ($categories->count()) {
                    $this->setCategoryId($categories->getFirstItem()->getId());
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
            /**
             * Filter all,onsale,instock,new
             */
            if (Mage::getStoreConfig('amastycustom/general/enable') == 1) {
                $this->_amastyExtraFilter($this->_productCollection);
            }

            $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());

            if ($origCategory) {
                $layer->setCurrentCategory($origCategory);
            }
        }

        return $this->_productCollection;
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
}
