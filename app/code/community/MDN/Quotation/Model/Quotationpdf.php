<?php

class MDN_Quotation_Model_QuotationPdf extends MDN_Quotation_Model_Pdfhelper {

    protected $_settings;
    public $_storeId = null;


    /**
     * Create PDF
     */
    public function getPdf($quotes = array()) {

        $this->_beforeGetPdf();
        $this->_initRenderer('invoice');

        //load Quote
        if (count($quotes) == 0)
            throw new Exception('No quote to print !');

        $quote = $quotes[0];
        $this->_storeId = $quote->getStoreId();

        Mage::app()->getLocale()->emulate($this->_storeId);

        $this->pdf = new Zend_Pdf();
        $style = new Zend_Pdf_Style();
        $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 10);

        //create new page
        $settings = array();
        $settings['title'] = '';
        $settings['store_id'] = 0;
        $title = Mage::helper('quotation')->__('Quotation #%s', $quote->getincrement_id());

        //if has business proposal, add the first page
        if ($quote->hasBusinessProposal()) {

            $page = $this->NewPage($settings);

            // main page
            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 32);
            $this->drawTextInBlock($page, $title, 0, $this->_PAGE_WIDTH / 2 + 50, $this->_PAGE_WIDTH - 80, 50, 'c');
            $this->drawTextInBlock($page, $quote->getcaption(), 0, $this->_PAGE_WIDTH / 2, $this->_PAGE_WIDTH - 80, 50, 'c');
            $this->drawFooter($page, $this->_storeId);

            // add business proposal
            $this->drawBusinessProposal($page, $quote, $settings);

            // new page
            $this->drawFooter($page, $this->_storeId);
        }

        $settings['title'] = $title;
        $this->_settings = $settings;
        $page = $this->NewPage($settings, $quote);
        $this->y -= 10;
        
        //Header
        $txt_date = Mage::helper('quotation')->__('Quotation Date : %s', Mage::helper('core')->formatDate($quote->getcreated_time(), 'long'));
        $txt_quote = Mage::helper('quotation')->__('Quotation valid until %s', Mage::helper('core')->formatDate($quote->getvalid_end_time(), 'long'));
        $adresse_fournisseur = Mage::getStoreConfig('sales/identity/address', $this->_storeId);
        if ($quote->GetCustomerAddress() != null){
            $adresse_client = $this->FormatAddress($quote->GetCustomerAddress(), '', false);
        }else {
            $adresse_client = $quote->GetCustomer()->getName();
        }
        $this->AddAddressesBlock($page, $adresse_client, $adresse_client, $txt_date, $txt_quote);

        // add listing products
        $this->drawListingProducts($page, $quote, $style, $settings);

        //new page if required

        if ($this->y < ($this->_BLOC_FOOTER_HAUTEUR + 100)) {
            $this->drawFooter($page, $settings['store_id']);
            $page = $this->NewPage($settings);
            $this->y -= 10;
            $this->drawTableHeader($page);
        }

        $this->drawTotals($page, $quote);
        $this->drawAgreement($page, $settings);
        $this->drawFooter($page, $this->_storeId);

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
        $page->drawText(Mage::helper('quotation')->__('SKU'), 15, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('quotation')->__('Qty Requested'), 70, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('quotation')->__('Image'), 200, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('quotation')->__('Description'), 310, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('quotation')->__('Barcode'), 500, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('quotation')->__('Price'), 590, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('quotation')->__('Subtotal'), 650, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('quotation')->__('Total'), 720, $this->y, 'UTF-8');

        $this->y -= 8;
        $page->drawLine(10, $this->y, $this->_BLOC_ENTETE_LARGEUR, $this->y);
        $this->y -= 15;
    }

    /**
     * Add listing products part
     *
     * @param Zend_Pdf_Page $page
     * @param MDN_Quotation_Model_Quotation $quote
     * @param Zend_Pdf_Style $style
     * @return int
     */
    protected function drawListingProducts(&$page, $quote, $style, $settings) {

        $this->drawTableHeader($page);

        $collection = $quote->getItems();
        $needBundle = Mage::getModel('Quotation/Quotation_Bundle')->needBundleProduct($quote);
        /*if ($needBundle && ($quote->getshow_detail_price() == 0)) {
            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
            $page->drawText($this->TruncateTextToWidth($page, '', 60), 15, $this->y, 'UTF-8');
            $caption = $this->WrapTextToWidth($page, $quote->getcaption(), 200);
            $caption .= $this->getConfigContentAsText($quote);
            $caption = $this->WrapTextToWidth($page, $caption, 450);
            $this->drawTextInBlock($page, $this->TruncateTextToWidth($page, $quote->GetLinkedProduct()->getsku(), 70), 10, $this->y, 40, 20, 'l');
            $offset = $this->DrawMultilineText($page, $caption, 90, $this->y, 10, 0.2, 11);
            $this->drawTextInBlock($page, 1, 275, $this->y, 40, 20, 'c'); //qty
            $this->drawTextInBlock($page, $quote->GetConfigFormatedPriceWithoutTaxes(), 490, $this->y, 60, 20, 'r');
            $this->drawTextInBlock($page, $quote->GetConfigFormatedPriceWithoutTaxes(), 560, $this->y, 60, 20, 'r');
            $this->drawTextInBlock($page, $quote->GetConfigFormatedPriceWithTaxes(), 640, $this->y, 60, 20, 'r');
            $this->y -= $this->_ITEM_HEIGHT + $offset;
        }*/

        foreach ($collection as $item) {
            $quote->setshow_detail_price(1);
            $this->y -= 20;
            $product = $item->getProduct();
            $imageLocation = Mage::helper('catalog/image')->init($product, 'image')
                    ->keepAspectRatio(true)
                    ->keepFrame(false)
                    // ->resize(60, 40)
                    ->__toString();

            $productImage = Zend_Pdf_Image::imageWithPath($imageLocation);

            if (($item->getexclude() == 1) || ($quote->getshow_detail_price() == 1)) {
                $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
                $page->drawText($this->TruncateTextToWidth($page, $item->getreference(), 60), 15, $this->y, 'UTF-8');
                $caption = $this->WrapTextToWidth($page, $item->getcaption(), 200);
                $this->drawTextInBlock($page, $this->TruncateTextToWidth($page, $item->getsku(), 70), 10, $this->y, 40, 20, 'l');
                
                $this->drawTextInBlock($page, $item->getqty(), 80, $this->y, 40, 20, 'c');
                //Draw product image to quotation pdf - HungDQ
                if($productImage){
                    $x1           = 185;
                    $y1           = $this->y - 15;
                    $page->drawImage($productImage, $x1, $y1, $x1 + 57.6, $y1 + 45);
                }
                $offset = $this->DrawMultilineText($page, $caption, 300, $this->y, 10, 0.2, 11);
                $this->drawTextInBlock($page, $product->getProductBarcodeUnit(), 540, $this->y, 20, 20, 'r');
                if ($quote->getshow_detail_price() || ($item->getexclude() == 1)) {
                    /*if ($item->getdiscount_purcent() > 0)
                        $this->drawTextInBlock($page, $item->getdiscount_purcent() . '%', 330, $this->y, 20, 20, 'r')*/;
                    //$this->drawTextInBlock($page, $quote->FormatPrice($item->GetUnitPriceWithoutTaxes($quote), $this->_storeId), 490, $this->y, 60, 20, 'r');
                    $this->drawTextInBlock($page, $quote->FormatPrice($item->getPrice_ht(), $this->_storeId), 690, $this->y, 60, 20, 'r');
                    
                    $this->drawTextInBlock($page, $quote->FormatPrice($item->GetTotalPriceWithoutTaxes($quote), $this->_storeId), 760, $this->y, 60, 20, 'r');
                    $this->drawTextInBlock($page, $quote->FormatPrice($item->GetTotalPriceWithTaxes($quote), $this->_storeId), 820, $this->y, 60, 20, 'r');
                }
                
                $this->y -= $this->_ITEM_HEIGHT + $offset + 50;

                //display options
                $optionsText = $item->getOptionsValuesAsText();
                if ($optionsText != '') {
                    $this->y += 10;
                    $offset = $this->DrawMultilineText($page, $optionsText, 105, $this->y, 10, 0.2, 11);
                    $this->y -= $this->_ITEM_HEIGHT + $offset;
                }

                //custom description
                if ($item->getdescription() != '') {
                    $this->y += 10;
                    $description = $item->getdescription();
                    $description = $this->WrapTextToWidth($page, $description, 450);
                    $offset = $this->DrawMultilineText($page, $description, 105, $this->y, 10, 0.2, 11);
                    $this->y -= $this->_ITEM_HEIGHT + $offset;
                }

                //new page if required
                if ($this->y < ($this->_BLOC_FOOTER_HAUTEUR + 40)) {
                    $this->drawFooter($page, $settings['store_id']);
                    $page = $this->NewPage($settings);
                    $this->y -= 10;
                    $this->drawTableHeader($page);
                }
            }
        }

        //Add shipping fees
        if (!Mage::getStoreConfig('quotation/pdf/display_shipping_in_totals'))
        {
            if ($quote->getfree_shipping() == 1) {
                $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 10);
                $this->DrawMultilineText($page, Mage::helper('quotation')->__('Free Shipping'), 90, $this->y, 10, 0.2, 11);
            } else {
                if ($quote->getshipping_method()) {
                    $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 10);
                    $this->DrawMultilineText($page, $quote->getshipping_description(), 90, $this->y, 10, 0.2, 11);
                    $this->drawTextInBlock($page, $quote->FormatPrice($quote->getShippingCostWithoutTax(), $this->_storeId), 560, $this->y, 60, 20, 'r');
                    $this->drawTextInBlock($page, $quote->FormatPrice($quote->getShippingCostWithTax(), $this->_storeId), 640, $this->y, 60, 20, 'r');
                }
            }
            $this->y -= $this->_ITEM_HEIGHT;
        }

        //add discount value
        if ($quote->getdiscount_value() > 0)
        {
            $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 10);
            $this->DrawMultilineText($page, Mage::helper('quotation')->__('Global Discount'), 90, $this->y, 10, 0.2, 11);
            $this->drawTextInBlock($page, $quote->FormatPrice(-$quote->getdiscount_value(), $this->_storeId), 560, $this->y, 60, 20, 'r');
            $this->drawTextInBlock($page, $quote->FormatPrice(-$quote->getDiscountValueWithTax(), $this->_storeId), 640, $this->y, 60, 20, 'r');
            $this->y -= $this->_ITEM_HEIGHT;
        }

        return true;
    }

    /**
     * Return bundle in string
     */
    public function getConfigContentAsText($quote) {

        $retour = '';
        foreach ($quote->getItems() as $item) {
            if ($item->getexclude() == 0) {
                $retour .= "\n" . $item->getqty() . 'x ' . $item->getcaption();

                //add product options
                $product = $item->getProduct();
                if ($product->gethas_options() == 1) {
                    foreach ($item->getOptionsCollection() as $option) {
                        $optionValue = $item->getOptionValueAsText($option->getId());
                        if ($optionValue != '')
                            $retour .= "\n......... " . $option->gettitle() . ' : ' . $optionValue;
                    }
                }

                //add custom description
                if ($item->getdescription() != '') {
                    $description = "\n" . $item->getdescription();
                    $retour .= $description;
                }
            }
        }
        return $retour;
    }

    /**
     * Add business proposal part
     *
     * @param Zend_Pdf_Page $page
     * @param MDN_Quotation_Model_Quotation $quote
     * @return int
     */
    protected function drawBusinessProposal(&$page, $quote, $settings) {

        $proposal = $quote->getbusiness_proposal();

        $xml = new DomDocument();
        $xml->loadXML($proposal);

        if ($proposal != null && $proposal != '' && $xml->getElementsByTagName(MDN_Quotation_Helper_Proposal::kSectionNode)->item(0)) {

            $this->drawFooter($page, $quote->getStoreId());
            $page = $this->NewPage($settings);
            $this->drawFooter($page, $storeId);

            $this->y -= 30;
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.3));

            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 24);
            $this->drawTextInBlock($page, Mage::Helper('quotation')->__('Business Proposal'), 0, $this->y, $this->_PAGE_WIDTH - 80, 50, 'c');

            $this->y -= 30;

            foreach ($xml->getElementsBytagName(MDN_Quotation_Helper_Proposal::kSectionNode) as $section) {

                // add title
                $this->y -= 10;
                $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 20);
                $page->drawText($section->getElementsByTagName(MDN_Quotation_Helper_Proposal::kTitleNode)->item(0)->nodeValue, 15, $this->y, 'UTF-8');
                $this->y -= 30;
                $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);

                // add content
                if ($section->getElementsByTagName(MDN_Quotation_Helper_Proposal::kModeNode)->item(0)->nodeValue == MDN_Quotation_Helper_Proposal::kModeList) {

                    $lines = explode("\n", $section->getElementsByTagName(MDN_Quotation_Helper_Proposal::kContentNode)->item(0)->nodeValue);

                    foreach ($lines as $line) {

                        if (trim($line) == '')
                            continue;

                        $line = $this->WrapTextToWidth($page, $line, 520);
                        $page->drawCircle(30, $this->y + 3, 2);
                        $t_line = explode("\n", $line);

                        foreach ($t_line as $elt) {
                            $page->drawText($elt, 55, $this->y, 'UTF-8');
                            $this->y -= 15;
                        }

                        $this->y -= 7;

                        //if we reach page footer, new page
                        if ($this->y < ($this->_BLOC_FOOTER_HAUTEUR + 150)) {
                            $this->drawFooter($page, $settings['store_id']);
                            $page = $this->NewPage($settings);
                            $this->y -= 30;
                            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.3));
                            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
                        }
                    }
                } else {
                    $content = $this->WrapTextToWidth($page, $section->getElementsByTagName(MDN_Quotation_Helper_Proposal::kContentNode)->item(0)->nodeValue, 520);
                    $t_content = explode("\n", $content);
                    for ($i = 0; $i < count($t_content); $i++) {

                        $line = $t_content[$i];

                        $page->drawText($line, 30, $this->y, 'UTF-8');

                        $this->y -= 15;

                        //if we reach page footer, new page
                        if ($this->y < ($this->_BLOC_FOOTER_HAUTEUR + 50)) {
                            $this->drawFooter($page, $settings['store_id']);
                            $page = $this->NewPage($settings);
                            $this->y -= 30;
                            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.3));
                            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
                        }
                    }
                }

                $this->y -= 30;
            }
        }

        return true;
    }

    /**
     * Add Draw totals
     *
     * @param Zend_Pdf_Page $page
     * @param MDN_Quotation_Model_Quotation $quote
     * @return int
     */
    protected function drawTotals($page, $quote) {

        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 14);

        $this->y -= 40;
        $page->drawText(Mage::helper('quotation')->__('Totals'), 15, $this->y, 'UTF-8');
        $this->y -= 5;
        $page->drawLine(10, $this->y, $this->_BLOC_ENTETE_LARGEUR, $this->y);

        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.2));
        $this->y -= 20;
        $totalExclTax = $quote->GetFinalPriceWithoutTaxes();
        if (Mage::getStoreConfig('quotation/pdf/display_shipping_in_totals'))
            $totalExclTax = $totalExclTax -  $quote->getShippingCostWithoutTax();
        $page->drawText(Mage::helper('quotation')->__('Total (excl tax)'), $this->_PAGE_WIDTH / 2, $this->y, 'UTF-8');
        $this->drawTextInBlock($page, $quote->FormatPrice($totalExclTax, $this->_storeId), $this->_PAGE_WIDTH / 2 + 40, $this->y, $this->_PAGE_WIDTH / 2, 40, 'r');
        $this->y -= 25;

        if (Mage::getStoreConfig('quotation/pdf/display_shipping_in_totals'))
        {
            $page->drawText(Mage::helper('quotation')->__('Shipping (excl tax)'), $this->_PAGE_WIDTH / 2, $this->y, 'UTF-8');
            $this->drawTextInBlock($page, $quote->FormatPrice($quote->getShippingCostWithoutTax(), $this->_storeId), $this->_PAGE_WIDTH / 2 + 40, $this->y, $this->_PAGE_WIDTH / 2, 40, 'r');
            $this->y -= 25;
        }

        $page->drawText(Mage::helper('quotation')->__('Tax'), $this->_PAGE_WIDTH / 2, $this->y, 'UTF-8');
        $this->drawTextInBlock($page, $quote->FormatPrice($quote->GetTaxAmount(), $this->_storeId), $this->_PAGE_WIDTH / 2 + 40, $this->y, $this->_PAGE_WIDTH / 2, 40, 'r');
        $this->y -= 25;

        $page->drawText(Mage::helper('quotation')->__('Total (incl tax)'), $this->_PAGE_WIDTH / 2, $this->y, 'UTF-8');
        $this->drawTextInBlock($page, $quote->FormatPrice($quote->GetFinalPriceWithTaxes(), $this->_storeId), $this->_PAGE_WIDTH / 2 + 40, $this->y, $this->_PAGE_WIDTH / 2, 40, 'r');
        $this->y -= 25;

        if ($quote->getReduction() > 0)
        {
            $page->drawText(Mage::helper('quotation')->__('Discount'), $this->_PAGE_WIDTH / 2, $this->y, 'UTF-8');
            $this->drawTextInBlock($page, $quote->getReduction().' %', $this->_PAGE_WIDTH / 2 + 15, $this->y, $this->_PAGE_WIDTH / 2, 15, 'c');
            $this->y -= 20;
        }

        return true;
    }

    /**
     * Add agreement part
     *
     * @param Zend_Pdf_Page $page
     * @return int
     */
    protected function drawAgreement(&$page, $settings) {

        if (!Mage::getStoreConfig('quotation/pdf/agreement', $settings['store_id']))
            return false;

        $this->y -= 40;
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.3));
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
        $page->drawText(Mage::helper('quotation')->__('Agreement'), 15, $this->y, 'UTF-8');
        $this->y -= 5;
        $page->drawLine(10, $this->y, $this->_BLOC_ENTETE_LARGEUR, $this->y);
        $this->y -= 15;
        $agreement = $this->WrapTextToWidth($page, Mage::getStoreConfig('quotation/pdf/agreement', $settings['store_id']), 600);

        //cutting $agreement
        $all_agreement = explode("\n", $agreement);

        foreach ($all_agreement as $value) {

            if ($this->y < ($this->_BLOC_FOOTER_HAUTEUR + 40)) {
                $this->drawFooter($page);
                $page = $this->NewPage($settings);
                $this->y -= 25;
                $offset = $this->DrawMultilineText($page, $value . "\n", 25, $this->y, 10, 0.2, 11);
                $this->y -= 11;
            } else {
                $height_text = $this->getMultilineTextHeight($page, $value . "\n", 10, 11);

                if ($height_text + 50 < $this->y) {
                    $offset = $this->DrawMultilineText($page, $value . "\n", 25, $this->y, 10, 0.2, 11);
                    $this->y -= 11;
                } else {
                    $this->drawFooter($page);
                    $page = $this->NewPage($settings);
                    $this->y -= 25;
                    $offset = $this->DrawMultilineText($page, $value . "\n", 25, $this->y, 10, 0.2, 11);
                    $this->y -= 11;
                }
            }
        }

        return true;
    }


}
