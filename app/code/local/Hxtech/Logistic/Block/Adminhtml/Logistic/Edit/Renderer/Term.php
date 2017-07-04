<?php

class Hxtech_Logistic_Block_Adminhtml_Logistic_Edit_Renderer_Term
	extends Mage_Adminhtml_Block_Widget 
    implements Varien_Data_Form_Element_Renderer_Interface
{
    public function __construct()
    {
        $this->setTemplate('logistic/term.phtml');
    }

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }

    /**
     * Set form element instance
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Price_Group_Abstract
     */
    public function setElement(Varien_Data_Form_Element_Abstract $element)
    {
        $this->_element = $element;
        return $this;
    }

    /**
     * Retrieve form element instance
     *
     * @return Varien_Data_Form_Element_Abstract
     */
    public function getElement()
    {
        return $this->_element;
    }
}
