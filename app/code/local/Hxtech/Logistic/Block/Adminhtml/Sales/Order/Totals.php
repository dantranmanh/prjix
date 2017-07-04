<?php 
class Hxtech_Logistic_Block_Adminhtml_Sales_Order_Totals extends Mage_Adminhtml_Block_Sales_Order_Totals
{
    /**
     * Initialize order totals array
     *
     * @return Mage_Sales_Block_Order_Totals
     */
    protected function _initTotals()
    {
        parent::_initTotals();
        $order = $this->getOrder();
        //Add Importer Fee Total row to invoice detail
        $importerFee = $order->getImporterCommissionFee();
 
        if ($importerFee > 0) {
            $this->addTotalBefore(new Varien_Object(array(
                'code'      => 'Importer_commission_fee',
                'value'     => $importerFee,
                'base_value'=> $importerFee,
                'label'     => 'Importer Fee',
            ), array('shipping', 'tax')));
        }
        
        //Add Documentation Fee Total row to invoice detail
        $documentId = $order->getDocumentId();
        $documentation = Mage::getModel('document/documentation')->load($documentId);
        $documentationFee = $documentation->getPrice() + $order->getDocumentFee();
 
        if ($documentationFee > 0) {
            $this->addTotalBefore(new Varien_Object(array(
                'code'      => 'document_fee',
                'value'     => $documentationFee,
                'base_value'=> $documentationFee,
                'label'     => 'Documentation Fee',
            ), array('shipping', 'tax')));
        }
 
        return $this;
    }
 
}