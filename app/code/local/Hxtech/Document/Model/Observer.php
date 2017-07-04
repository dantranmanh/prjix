<?php
/**
 * Ixport - Document
 *
 * NOTICE OF LICENSE
 *
 * Private Proprietary Software (http://ixport.com/legal)
 *
 * @category   Hxtech
 * @package    Hxtech_Document
 * @copyright  Copyright (c) 2017 Ixport (http://ixport.com)
 * @license    http://ixport.com/legal  Private Proprietary Software
 * @author     Shaughn Le Grange - Hatlen <me@shaughn.pro>
 */

class Hxtech_Document_Model_Observer
{
    /**
     * Send documentation order email
     *
     * Event: sales_order_invoice_pay
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function sendDocumentationOrderEmail(Varien_Event_Observer $observer)
    {
        /** @var Mage_Sales_Model_Order_Invoice $invoice */
        $invoice = $observer->getEvent()->getData('invoice');

        try {
            $order = $invoice->getOrder();
            $storeId = $order->getStoreId();

            $documentId = $order->getData('document_id');
            $shippingRateId = $order->getData('shipping_rate_id');

            $documentation = Mage::getModel('document/documentation')->load($documentId);
            $shippingRate = Mage::getModel('logistic/shippingrate')->load($shippingRateId);

            /* @var Mage_Payment_Block_Info $paymentBlock */
            $paymentBlock = Mage::helper('payment')->getInfoBlock($order->getPayment())->setIsSecureMode(true);
            $paymentBlock->getMethod()->setStore($storeId);
            $paymentBlockHtml = $paymentBlock->toHtml();

            if ($documentation->getId()) {
                Mage::helper('document/documentation')
                    ->sendDocumentationOrderEmail($documentation, $storeId, $order, $paymentBlockHtml, $shippingRate);
            }
        } catch (Exception $e) {
            Mage::helper('document')->exception($e);
        }
    }

    /**
     * Add invoice attachment
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function addInvoiceAttachment(Varien_Event_Observer $observer)
    {
        $mailer = $observer->getEvent()->getMailer()
            ? $observer->getEvent()->getMailer()
            : $observer->getEvent()->getMail();

        /** @var Fooman_EmailAttachments_Model_Core_Email_Queue $message */
        $message = $observer->getEvent()->getMessage();

        try {
            if ($message->getEntityType() == 'order' && !$message->getProcessedAt()) {
                $order = Mage::getModel('sales/order')->load($message->getEntityId());
                $invoices = $order->getInvoiceCollection();
                $invoicesSet = [];

                foreach ($invoices as $_invoice) {
                    array_push($invoicesSet, $_invoice);
                }

                /* Add pdf invoice to the order confirmation email */
                if (count($invoicesSet) > 0) {
                    $pdf = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoicesSet);
                    Mage::helper('emailattachments')->addAttachment(
                        $pdf, $mailer, 'invoice'
                    );
                }
            }
        } catch (Exception $e) {
            Mage::helper('document')->exception($e);
        }
    }
}