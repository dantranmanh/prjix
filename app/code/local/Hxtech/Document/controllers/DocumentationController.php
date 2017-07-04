<?php

class Hxtech_Document_DocumentationController extends Mage_Core_Controller_Front_Action
{
    protected function _getQuote()
    {
        return Mage::getSingleton('checkout/session')->getQuote();
    }
    
    public function setDocumentationAction()
    {
        $result = array();
        $_params = $this->getRequest()->getParams();
        $quote = $this->_getQuote();

        $documentationId = $_params['id'];
        
        if($documentationId){
            $documentation = Mage::getModel('document/documentation')->load($documentationId);
            $supplier = Mage::helper('document/documentation')->getSupplierOfDocumentation($documentation);
            $quote->setDocumentId($documentationId)->setDocumentSupplierId($supplier->getId())->save();
            $documentationFee = Mage::helper('document/documentation')->getDocumentationTotalFee($documentation, $quote->getSubtotal());
            Mage::getSingleton('checkout/session')->setDocumentation($documentation);
        }else{
            Mage::getSingleton('checkout/session')->unsDocumentation();
        }
        $html = Mage::app()->getLayout()->createBlock('logistic/checkout_total')->setTemplate('hxtech/logistic/checkout/total.phtml')->toHtml();
        $result['html'] = $html;

        $result['forex_html'] = Mage::app()->getLayout()->createBlock('forex/financier_list')
            ->setTemplate('hxtech/forex/checkout/list.phtml')
            ->toHtml();

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}