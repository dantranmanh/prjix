<?php

class Hxtech_Logistic_Model_Observer
{
	public function applyCommissionRate($observer)
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $order = $observer->getOrder();
        $logisticId = $quote->getLogisticId();
        $logistic = Mage::getModel('admin/user')->load($logisticId);
        $documentSupplierId = $quote->getDocumentSupplierId();
        $commissionFee = 0;
        $commissionType = 0;


            $importer = Mage::getSingleton('customer/session')->getCustomer();
            $importerCommissionData = Mage::helper('logistic/importer')->getImporterCommissionData($importer);
            $importerCommissionType = $importerCommissionData->getCommissionType();
            $importerCommissionFee = Mage::helper('logistic/importer')->getImporterCommissionFee($quote->getSubtotal());


        $documentCommissionFee = Mage::helper('document/documentation')->getDocumentCommissionFee($documentSupplierId, $order->getSubtotal());
        $documentCommissionType = Mage::helper('document/documentation')->getDocumentCommissionType($documentSupplierId);

        if($logistic->getCommissionStatus() == 1){
            $commissionFee = Mage::helper('logistic/logistic')->getLogisticCommissionFee($logisticId, $order);
            $commissionType = Mage::helper('logistic/logistic')->getLogisticCommissionType($logisticId);
        }

        $order
            ->setCommissionFee($commissionFee)
            ->setDocumentFee($documentCommissionFee)
            ->setCommissionType($commissionType)
            ->setDocumentCommissionType($documentCommissionType)
            ->setImporterCommissionType($importerCommissionType)
            ->setImporterCommissionFee($importerCommissionFee)
            ->save();
        $quote
            ->setCommissionFee($commissionFee)
            ->setDocumentFee($documentCommissionFee)
            ->setCommissionType($commissionType)
            ->setDocumentCommissionType($documentCommissionType)
            ->setImporterCommissionType($importerCommissionType)
            ->setImporterCommissionFee($importerCommissionFee)
            ->save();
    }

    public function addImporterTierCommissionTab($observer)
    {
        $block = $observer->getBlock();
        if (!$block instanceof Mage_Adminhtml_Block_Customer_Edit_Tabs
            || !Mage::app()->getRequest()->getParam('id', 0)
        ) {
            return;
        }

        if ($block instanceof Mage_Adminhtml_Block_Customer_Edit_Tabs) {
            $block->addTab('importer_tier_commission_tab', array(
                'label' => Mage::helper('logistic')->__('Transaction Fees'),
                'title' => Mage::helper('logistic')->__('Transaction Fees'),
                'content' => $block->getLayout()->createBlock('logistic/adminhtml_customer_edit_tab_commission')->toHtml(),
            ));

            $block->addTab('importer_order_commission', array(
                'label' => Mage::helper('logistic')->__('Transaction Fee History'),
                'title' => Mage::helper('logistic')->__('Transaction Fee History'),
                'url' => $block->getUrl('logistic/adminhtml_importer/orderTab', array('_current' => true)),
                'class' => 'ajax',
            ));
        }
    }

    public function saveImporterCommission($observer)
    {
        $customer = $observer->getCustomer();
        $request = $observer->getRequest();
        $post = $request->getPost();
        //Save importer commission config data
        $configModel = Mage::getModel('logistic/importerconfig')->load($customer->getId(), 'importer_user_id');
        $configModel
            ->setCommissionStatus($post['commission_status'])
            ->setImporterUserId($customer->getId())
            ->setCommissionType($post['commission_type'])
            ->setCommissionFixedFee($post['commission_fixed_fee'])
            ->setCommissionPercentageFee($post['commission_percentage_fee']);

        //Save importer commission tier data
        if(isset($post['tier_commission']) && $customer->getId()){
            foreach($post['tier_commission'] as $tierCommission){
                $tierModel = Mage::getModel('logistic/importertier');
                if($tierCommission['delete'] == ''){
                    $tierModel->saveTierCommission($tierCommission, $customer->getId());
                }else{
                    $tierModel->deleteTierCommission($tierCommission);
                }
            }
        }    

        try {
            $configModel->save();
        } catch (Exception $e) {
            Mage::logException($e->getMessage());
        }
    }

    public function saveCustomerClosestPort(Varien_Event_Observer $observer)
    {
        $params = Mage::app()->getRequest()->getParams();
        if(isset($params['closest_port'])){
            $closestPort = $params['closest_port'];
            $event = $observer->getEvent();
            $customer = $event->getCustomer();
            try {
                $customer->setClosestPort($closestPort)->save();
            } catch (Exception $e) {
                Mage::logException($e->getMessage());
            }
        }
    }

    public function addCustomerExportButton($event)
    {
        $block = $event->getBlock();
        $customerId = Mage::app()->getRequest()->getParam('id');
        if ($block instanceof Mage_Adminhtml_Block_Customer_Edit) {
            $block->addButton('export_volumetric', array(
                'label'     => Mage::helper('logistic')->__('Export Volumetric'),
                'onclick'   => "setLocation('".Mage::helper('adminhtml')->getUrl('logistic/adminhtml_logistic/exportVolumetric', array('customerId' => $customerId))."')",
            ));
        }
    }

    /**
     * Send logistic order email
     *
     * Event: sales_order_invoice_pay
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function sendLogisticOrderEmail(Varien_Event_Observer $observer)
    {
        /** @var Mage_Sales_Model_Order_Invoice $invoice */
        $invoice = $observer->getEvent()->getData('invoice');

        try {
            $order = $invoice->getOrder();
            $storeId = $order->getStoreId();

            $shippingRateId = $order->getData('shipping_rate_id');
            $shippingRate = Mage::getModel('logistic/shippingrate')->load($shippingRateId);

            /** @var Mage_Payment_Block_Info $paymentBlock */
            $paymentBlock = Mage::helper('payment')->getInfoBlock($order->getPayment())->setIsSecureMode(true);
            $paymentBlock->getMethod()->setStore($storeId);
            $paymentBlockHtml = $paymentBlock->toHtml();

            if ($shippingRate->getId()) {
                $logistic = Mage::helper('logistic/logistic')->getLogisticOfShippingrate($shippingRate);

                Mage::helper('logistic/logistic')
                    ->sendLogisticOrderEmail($logistic, $storeId, $order, $paymentBlockHtml, $shippingRate);
            }
        } catch (Exception $e) {
            Mage::helper('logistic')->exception($e);
        }
    }
}