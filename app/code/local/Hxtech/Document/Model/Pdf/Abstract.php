<?php

abstract class Hxtech_Document_Model_Pdf_Abstract extends Mage_Sales_Model_Order_Pdf_Abstract {

    protected $_BLOC_ENTETE_HAUTEUR = 50;
    protected $_BLOC_ENTETE_LARGEUR = 820;
    protected $_BLOC_FOOTER_HAUTEUR = 40;
    protected $_BLOC_FOOTER_LARGEUR = 820;
    protected $_LOGO_HAUTEUR = 50;
    protected $_LOGO_LARGEUR = 585;
    protected $_PAGE_HEIGHT = 820;
    protected $_PAGE_WIDTH = 900;
    protected $_ITEM_HEIGHT = 25;
    public $pdf;
    protected $firstPageIndex = 0;

    /**
     * Calculate multiline text height
     *
     */
    public function getMultilineTextHeight($page, $Text, $Size, $LineHeight) {
        $retour = -$LineHeight;
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $Size);
        foreach (explode("\n", $Text) as $value) {
            if ($value !== '') {
                $retour += $LineHeight;
            }
        }
        return $retour;
    }

    /**
     * Draw multiline text and return total height
     */
    protected function DrawMultilineText($page, $Text, $x, $y, $Size, $GrayScale, $LineHeight) {
        $retour = -$LineHeight;
        $page->setFillColor(new Zend_Pdf_Color_GrayScale($GrayScale));
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $Size);
        foreach (explode("\n", $Text) as $value) {
            if ($value !== '') {
                $page->drawText(trim(strip_tags($value)), $x, $y, 'UTF-8');
                $y -=$LineHeight;
                $retour += $LineHeight;

                if (($y < $this->_BLOC_FOOTER_HAUTEUR)) {
                    $savedFont = $page->getFont();
                    $savedFontSize = $page->getFontSize();
                    $this->drawFooter($page, $this->_settings['store_id']);
                    $page = $this->NewPage($this->_settings);
                    $this->drawTableHeader($page);
                    $y = $this->y;
                    $retour = 0;

                    //re apply font (because new page can change font settings
                    $page->setFont($savedFont, $savedFontSize);
                }
            }
        }
        return $retour;
    }

    /**
     * Draw text in a specific box
     *
     */
    public function drawTextInBlock($page, $text, $x, $y, $width, $height, $alignment = 'c', $encoding = 'UTF-8') {
        $text_width = $this->widthForStringUsingFontSize($text, $page->getFont(), $page->getFontSize());
        switch ($alignment) {
            case 'c': //center text
                $x = $x + ($width / 2) - $text_width / 2;
                break;
            case 'r': //right align
                $x = $x + $width - $text_width;
        }

        $page->drawText(trim(strip_tags($text)), $x, $y, $encoding);
    }

    /**
     * Draw footer
     *
     * @param unknown_type $page
     */
    public function drawFooter($page, $StoreId = null) {
        //Background
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.7));
        $page->drawRectangle(10, $this->_BLOC_FOOTER_HAUTEUR + 15, $this->_BLOC_FOOTER_LARGEUR, 15, Zend_Pdf_Page::SHAPE_DRAW_FILL);

        //text
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.2));
    }

    /**
     * Draw header
     */
    public function drawHeader($page, $title, $StoreId = null) {

        //background
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.7));
        $page->setFillColor(Zend_Pdf_Color_Html::color('#FFFFFF'));
        $page->drawRectangle(10, $this->y, $this->_BLOC_ENTETE_LARGEUR, $this->y - $this->_BLOC_ENTETE_HAUTEUR, Zend_Pdf_Page::SHAPE_DRAW_FILL);
        //Title
        $name = $title;
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.3));
        if ($title != '') {
            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 24);
            $this->drawTextInBlock($page, $name, 0, $this->y, $this->_PAGE_WIDTH - 80, 50, 'c');
            $this->y -= 10;
            $page->drawLine(10, $this->y, $this->_BLOC_ENTETE_LARGEUR, $this->y);
        }
    }

    /**
     * Add new page (draw header / footer)
     *
     */
    public function NewPage(array $settings = array()) {
        $page = $this->pdf->newPage(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);
        $this->pdf->pages[] = $page;

        //on place Y tout en haut
        $this->y = 550;

        //dessine l'entete
        $this->drawHeader($page, $settings['title'], $settings['store_id']);

        //retourne la page
        return $page;
    }

    /**
     * Truncate text to fit width
     * 
     */
    public function TruncateTextToWidth($page, $text, $width) {
        $current_width = $this->widthForStringUsingFontSize($text, $page->getFont(), $page->getFontSize());
        while ($current_width > $width) {
            $text = substr($text, 0, strlen($text) - 1);
            $current_width = $this->widthForStringUsingFontSize($text, $page->getFont(), $page->getFontSize());
        }
        return $text;
    }

    /**
     * Add line return to fit multiline text to width
     *
     * @param unknown_type $text
     * @param unknown_type $width
     */
    public function WrapTextToWidth($page, $text, $width) {
        $t_words = explode(' ', $text);
        $retour = "";
        $current_line = "";
        for ($i = 0; $i < count($t_words); $i++) {
            if ($this->widthForStringUsingFontSize($current_line . ' ' . $t_words[$i], $page->getFont(), $page->getFontSize()) < $width) {
                $current_line .= ' ' . $t_words[$i];
            } else {
                if (($current_line != '') && (strlen($current_line) > 2))
                    $retour .= $current_line . "\n";
                $current_line = $t_words[$i];
            }

            if (strpos($t_words[$i], "\n") === false) {
                
            } else {
                if (($current_line != '') && (strlen($current_line) > 2))
                    $retour .= $current_line;
                $current_line = '';
            }
        }
        $retour .= $current_line;

        return $retour;
    }

    /**
     * Draw page number
     *
     */
    public function AddPagination($pdf) {
        $page_count = count($pdf->pages);
        for ($i = 0; $i < $page_count; $i++) {
            if ($i >= $this->firstPageIndex) {
                $page = $pdf->pages[$i];
                $pagination = ($i + 1 - $this->firstPageIndex) . ' / ' . ($page_count - $this->firstPageIndex);
                $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.3));
                $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
                $this->drawTextInBlock($page, $pagination, 0, 25, $this->_PAGE_WIDTH - 20, 40, 'r');
            }
        }
    }

    /**
     * Draw addresses & main text
     *
     */
    public function AddSupplierInfoBlock($page, $supplier) {
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 14);
        $this->y -= 20;

        $page->drawText($supplier->getUsername(), 25, $this->y, 'UTF-8');
        $this->y -= 15;
        $page->drawText($supplier->getEmail(), 25, $this->y, 'UTF-8');
        $this->y -= 15;
        $page->drawText($supplier->getStreet(), 25, $this->y, 'UTF-8');
        $this->y -= 15;
        $page->drawText($supplier->getWebsite(), 25, $this->y, 'UTF-8');
        $this->y -= 15;
        $page->setLineWidth(1.5);
        $page->drawLine(10, $this->y, $this->_BLOC_ENTETE_LARGEUR, $this->y);
    }
}
