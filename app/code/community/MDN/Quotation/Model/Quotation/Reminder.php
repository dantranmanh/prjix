<?php

class MDN_Quotation_Model_Quotation_Reminder extends Mage_Core_Model_Abstract {

    /**
     * Process quotes to remind them
     */
    public function process()
    {

        $reminderDelay = Mage::getStoreConfig('quotation/customer_reminder/delay', 0);

        $maxNotificationDate = date('Y-m-d', time() - 3600 * 24 * $reminderDelay);

        Mage::helper('quotation')->log('Process remind for quote notified before '.$maxNotificationDate);

        //get active, not bought, not reminded quotes
        $collection = Mage::getModel('Quotation/Quotation')
                                    ->getCollection()
                                    ->addFieldToFilter('bought', array('in' => array(0, 2)))
                                    ->addFieldToFilter('reminded', 0)
                                    ->addFieldToFilter('product_id', array('gt' => 0))
                                    ->addFieldToFilter('notification_date', array('lt' => $maxNotificationDate))
                                    ->addFieldToFilter('status', MDN_Quotation_Model_Quotation::STATUS_ACTIVE);

        Mage::helper('quotation')->log($collection->getSize().' quotes to remind');

        foreach($collection as $quote)
        {
            $this->sendCustomerReminder($quote);
        }

        Mage::helper('quotation')->log('End process remind');
    }

    /**
     * Send reminder to customer
     *
     */
    public function sendCustomerReminder($quote) {

        Mage::helper('quotation')->log('Send reminder for quote #'.$quote->getIncrementId());

        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $templateId = Mage::getStoreConfig('quotation/customer_reminder/email_template', $quote->getStoreId());
        $identityId = Mage::getStoreConfig('quotation/customer_reminder/email_identity', $quote->getStoreId());

        //var to use in template
        $data = array
            (
            'subject' => Mage::helper('quotation')->__('Quotation reminder'),
            'customer_name' => $quote->getCustomer()->getName(),
            'url' => Mage::getUrl(''),
            'quote_name' => $quote->getcaption(),
            'direct_url' => Mage::helper('quotation/DirectAuth')->getDirectUrl($quote)
        );

        //envoi le mail
        if (!empty($templateId)) {
            Mage::getModel('Quotation/Core_Email_Template')
                    ->setDesignConfig(array('area' => 'adminhtml', 'store' => $quote->getStoreId()))
                    ->sendTransactionalWithAttachment(
                            $templateId,
                            $identityId,
                            $quote->getCustomer()->getemail(),
                            null,
                            $data,
                            null);
        } else {
            throw new Exception('Empty email template.');
        }

        $translate->setTranslateInline(true);
        $quote->setreminded(1)->save();
        $quote->addHistory(Mage::helper('quotation')->__('Customer reminded'));

        return $this;
    }

}