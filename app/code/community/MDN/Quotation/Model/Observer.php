<?php

class MDN_Quotation_Model_Observer {

    /**
     * Cron to remind customer and store bought tag
     *
     * @param Varien_Event_Observer $observer
     */
    public function updateStatus() {

        //remind clients
        if (Mage::getStoreConfig('quotation/customer_reminder/enable'))
            Mage::getSingleton('Quotation/Quotation_Reminder')->process();

        //set quotes to expired
        Mage::getSingleton('Quotation/Quotation_Expirer')->process();

        //clean bundles
        Mage::helper('quotation/Tools')->cleanBundles();

    }

    /**
     * Toggle quote to bought & append comments if placed order contains at least one quote item
     *
     * @param Varien_Event_Observer $observer
     */
    public function sales_order_afterPlace(Varien_Event_Observer $observer) {

        try
        {
            $quoteIds = array();

            $order = $observer->getEvent()->getOrder();
            foreach($order->getAllItems() as $orderItem)
            {
                $request = $orderItem->getBuyRequest();
                if (($request->getmdn_quote_id() > 0) && (!in_array($request->getmdn_quote_id(), $quoteIds)))
                    $quoteIds[] = $request->getmdn_quote_id();

            }

            if (count($quoteIds) > 0)
            {
                $collection = Mage::getModel('Quotation/Quotation')->getCollection()->addFieldToFilter('quotation_id', array('in' => $quoteIds));
                foreach($collection as $quote)
                {
                    $quote->setbought(1)->save();
                    $quote->addHistory(Mage::helper('quotation')->__('Purchased with order #%s', $order->getincrement_id()));
                }
            }

        }
        catch(Exception $ex)
        {
            Mage::logException($ex);
        }

    }


}

