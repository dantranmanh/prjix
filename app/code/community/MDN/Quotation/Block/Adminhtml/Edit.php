<?php


class MDN_Quotation_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    /**
     * Set buttons
     *
     */
    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_controller = 'Adminhtml';
        $this->_blockGroup = 'Quotation';


        $this->_addButton(
                'notify_customer',
                array(
                    'label' => Mage::helper('quotation')->__('Notify'),
                    'onclick' => "window.location.href='" . $this->getUrl('adminhtml/Quotation_Admin/notify', array('quote_id' => $this->getRequest()->getParam('quote_id'))) . "'"
                )
        );

        $this->_addButton(
                'remind_customer',
                array(
                    'label' => Mage::helper('quotation')->__('Remind'),
                    'onclick' => "window.location.href='" . $this->getUrl('adminhtml/Quotation_Admin/RemindCustomer', array('quote_id' => $this->getRequest()->getParam('quote_id'))) . "'"
                )
        );

        $this->_addButton(
                'print',
                array(
                    'label' => Mage::helper('quotation')->__('Print'),
                    'class' => 'print',
                    'onclick' => "window.location.href='" . $this->getUrl('adminhtml/Quotation_Admin/print', array('quote_id' => $this->getRequest()->getParam('quote_id'))) . "'"
                )
        );

        $this->_addButton(
                'duplicate',
                array(
                    'label' => Mage::helper('quotation')->__('Duplicate'),
                    'class' => 'add',
                    'onclick' => "window.location.href='" . $this->getUrl('adminhtml/Quotation_Admin/Duplicate', array('quotation_id' => $this->getRequest()->getParam('quote_id'))) . "'"
                )
        );

        $this->_addButton(
                'delete',
                array(
                    'label' => Mage::helper('quotation')->__('Delete'),
                    'class' => 'delete',
                    'onclick' => "if (confirm('".$this->__('Are you sure ?')."')) { window.location.href='" . $this->getUrl('adminhtml/Quotation_Admin/delete', array('quote_id' => $this->getRequest()->getParam('quote_id'))) . "' }"
                )
        );

        $this->_updateButton('save', 'onclick', 'beforeSaveQuote()');

    }

    /**
     * main title
     *
     * @return unknown
     */
    public function getHeaderText() {
        return Mage::helper('quotation')->__('Edit Quote %s', $this->getQuote()->getincrement_id().' - '. $this->getQuote()->getcaption(). ' ('.$this->getQuote()->getcustomer_name().')');
    }

    /**
     * Return back url
     */
    public function GetBackUrl() {
        return $this->getUrl('adminhtml/Quotation_Admin/List', array());
    }

    /**
     * Return current quote
     */
    public function getQuote()
    {
        return Mage::registry('current_quote');
    }

}
