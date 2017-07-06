<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */

class Amasty_Shopby_Helper_Layer_View_Strategy_Stock extends Amasty_Shopby_Helper_Layer_View_Strategy_Abstract
{
    protected function setTemplate()
    {
        return 'amasty/amshopby/attribute.phtml';
    }

    protected function setPosition()
    {
        return Mage::getStoreConfig('amshopby/general/stock_filter_pos');
    }

    protected function setHasSelection()
    {
        return !is_null(Mage::app()->getRequest()->getParam('stock'));
    }

	protected function setCollapsed()
	{
		return $this->isCollapseEnabled() && Mage::getStoreConfig('amshopby/general/stock_collapsed');
	}
}