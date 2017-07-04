<?php

class Hxtech_Barcode_Model_Pdf_Cart extends Fooman_PdfCustomiser_Model_Abstract
{
    const PDFCUSTOMISER_PDF_TYPE='shipment';

    public function getPdfType()
    {
        return self::PDFCUSTOMISER_PDF_TYPE;
    }

    public function renderPdf($quote) 
    {
        if (empty($quote)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('adminhtml')->__('There are no printable documents')
            );
            return false;
        }

        $this->_beforeGetPdf();

        $storeId = 1;

        //work with a new pdf or add to existing one
        if (empty($pdf)) {
            $pdf = $this->getMypdfModel($storeId);
        }

        $printedIncrements = array();
        $i = $pdf->getNumPages();
        if ($i > 0) {
            $pdf->endPage();
        }

        // create new PDF helper
        $pdfHelper = Mage::helper('pdfcustomiser/pdf_shipment');

        $storeId = 1;
        //force to print from an alternative store
        if ($storeId) {
            $appEmulation = Mage::getSingleton('core/app_emulation');
            $initial = $appEmulation->startEnvironmentEmulation(
                $storeId, Mage_Core_Model_App_Area::AREA_FRONTEND, true
            );
        }

        $pdfHelper->setStoreId($storeId);
        // $pdfHelper->setSalesObject($shipment);
        $pdfHelper->setPdf($pdf);
        $pdf->setStoreId($storeId);
        $pdf->setPdfHelper($pdfHelper);
        // set standard pdf info
        $pdf->SetStandard($pdfHelper);

        // add a new page
        $pdf->setIncrementId(0981234123);
        $printedIncrements[]= 0981234123;
        if ($i == 0) {
            $pdf->AddPage();
        } else {
            $pdf->startPage();
        }

        // Prepare Line Items
        $pdf->prepareLineItems($pdfHelper, $quote, null);

        //Prepare Items
        $itemsTemplate = $pdfHelper->getTemplateFileWithPath(
            $pdfHelper,
            'items'
        );
        $items = Mage::app()->getLayout()->createBlock('pdfcustomiser/pdf_items')
            ->setPdf($pdf)
            ->setPdfHelper($pdfHelper)
            ->setTemplate($itemsTemplate)
            ->toHtml();

        //Put it all together
        $pdf->SetFont($pdfHelper->getPdfFont(), '', $pdfHelper->getPdfFontsize('small'));
        $pdf->writeHTML($items, false, false, false, false, '');
        $pdf->SetFont($pdfHelper->getPdfFont(), '', $pdfHelper->getPdfFontsize());
        //reset Margins in case there was a page break
        $pdf->setMargins($pdfHelper->getPdfMargins('sides'), $pdfHelper->getPdfMargins('top'));

        $pdf->endPage();

        if ($storeId) {
            $appEmulation->stopEnvironmentEmulation($initial);
        }
        $pdf->setPdfAnyOutput(true);

        //output PDF document
        if ($pdf->getPdfAnyOutput()) {
            // reset pointer to the last page
            $pdf->lastPage();
            $pdf->Output(
                // $pdfHelper->getPdfFileName($printedIncrements),
                'Cart content.pdf',
                $pdfHelper->getNewWindow()
            );
            exit;
        } else {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('adminhtml')->__('There are no printable documents')
            );
        }

        $this->_afterGetPdf();
        return $pdf;
    }

}
