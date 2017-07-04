<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Quickview
 */
class Amasty_Quickview_Block_Page extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('amasty/amquickview/page.phtml');
    }

    //get setting value After Adding a Product Redirect to Shopping Cart
    public function isRedirectToShoppingCart()
    {
        return (int)Mage::getStoreConfig('checkout/cart/redirect_to_cart');
    }
}