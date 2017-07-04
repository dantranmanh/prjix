<?php

class Hxtech_Logistic_Model_Pdf_Logistic extends Hxtech_Logistic_Model_Pdf_Abstract 
{
    protected $_settings;
    /**
     * Create PDF
     */
    public function getPdf($logistic = array()) 
    {
        $this->_beforeGetPdf();
        // $this->_initRenderer('invoice');

        //load Quote
        if (count($logistic) == 0)
            throw new Exception('Cannot find logistic to print !');

        $logistic = $logistic[0];
        $this->pdf = new Zend_Pdf();
        $style = new Zend_Pdf_Style();
        $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 10);

        //create new page
        $settings = array();
        $settings['title'] = '';
        $settings['store_id'] = 0;
        $title = Mage::helper('logistic')->__('Freight Forwarder History');
        $settings['title'] = $title;
        $this->_settings = $settings;
        $page = $this->NewPage($settings);
        //Header
        $this->AddLogisticInfoBlock($page, $logistic);

        // add listing products
        $this->drawListingProducts($page, $logistic, $style, $settings);

        //new page if required

        // if ($this->y < ($this->_BLOC_FOOTER_HAUTEUR + 100)) {
        //     $this->drawFooter($page, $settings['store_id']);
        //     $page = $this->NewPage($settings);
        //     $this->y -= 10;
        //     $this->drawTableHeader($page);
        // }

        $this->drawFooter($page, null);

        //display page number
        $this->AddPagination($this->pdf);

        $this->_afterGetPdf();

        //reset language
        Mage::app()->getLocale()->revert();

        return $this->pdf;
    }

    /**
     * Draw products table header
     *
     * @param unknown_type $page
     */
    public function drawTableHeader(&$page) {

        $this->y -= 15;
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
        $page->drawText(Mage::helper('logistic')->__('Order #'), 15, $this->y, 'UTF-8');
        // $page->drawText(Mage::helper('logistic')->__('Status'), 125, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('logistic')->__('Purchased On'), 190, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('logistic')->__('Total Order Value Of Goods Sold'), 310, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('logistic')->__('Total Invoice Value'), 510, $this->y, 'UTF-8');
        // $page->drawText(Mage::helper('logistic')->__('Commission Algorithm'), 590, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('logistic')->__('Commission Fee'), 700, $this->y, 'UTF-8');

        $this->y -= 8;
        $page->drawLine(10, $this->y, $this->_BLOC_ENTETE_LARGEUR, $this->y);
        $this->y -= 15;
    }

    /**
     * Add listing products part
     *
     * @param Zend_Pdf_Page $page
     * @param Hxtech_Logistic_Model_Pdf_Logistic $logistic
     * @param Zend_Pdf_Style $style
     * @return int
     */
    protected function drawListingProducts(&$page, $logistic, $style, $settings) {

        $this->drawTableHeader($page);
        $collection = Mage::getModel('sales/order')->getCollection()->addFieldToFilter('logistic_id', $logistic->getId());

        foreach ($collection as $item) {
            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
            $incrementId = $this->WrapTextToWidth($page, $item->getIncrementId(), 40);
            $this->DrawMultilineText($page, $incrementId, 10, $this->y, 9, 0.2, 11);
            // $this->drawTextInBlock($page, $this->TruncateTextToWidth($page, $item->getStatus(), 70), 120    , $this->y, 40, 20, 'l');
            $this->drawTextInBlock($page, $this->TruncateTextToWidth($page, $item->getCreatedAt(), 120), 180    , $this->y, 40, 20, 'l');
            $this->drawTextInBlock($page, $this->TruncateTextToWidth($page, Mage::helper('core')->currency($item->getSubtotal(), true, false), 70), 350 , $this->y, 40, 20, 'l');
            $this->drawTextInBlock($page, $this->TruncateTextToWidth($page, Mage::helper('core')->currency($item->getGrandTotal(), true, false), 70), 530 , $this->y, 40, 20, 'l');
            // $this->drawTextInBlock($page, $this->TruncateTextToWidth($page, Mage::helper('logistic')->getCommisionNameByType($item->getCommissionType()), 70), 630 , $this->y, 40, 20, 'l');
            $this->drawTextInBlock($page, $this->TruncateTextToWidth($page, Mage::helper('core')->currency($item->getCommissionFee(), true, false), 70), 710 , $this->y, 40, 20, 'l');
            $this->y -= 20;
            //new page if required
            if ($this->y < ($this->_BLOC_FOOTER_HAUTEUR + 40)) {
                $this->drawFooter($page, null);
                $page = $this->NewPage($settings);
                $this->drawTableHeader($page);
            }
        }
        return true;
    }
}