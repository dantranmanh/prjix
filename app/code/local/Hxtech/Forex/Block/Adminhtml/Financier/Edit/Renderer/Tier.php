<?php

class Hxtech_Forex_Block_Adminhtml_Financier_Edit_Renderer_Tier
	extends Mage_Adminhtml_Block_Widget 
    implements Varien_Data_Form_Element_Renderer_Interface
{

    /**
     * Initialize block
     */
    public function __construct()
    {
        $this->setTemplate('forex/tier.phtml');
    }

    /**
     * Prepare global layout
     * Add "Add tier" button to layout
     *
     * @return Hxtech_Forex_Block_Adminhtml_Financier_Edit_Renderer_Tier
     */
    protected function _prepareLayout()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('logistic')->__('Add Tier'),
                'onclick' => 'return tierPriceControl.addItem()',
                'class' => 'add'
            ));
        $button->setName('add_tier_price_item_button');

        $this->setChild('add_button', $button);
        return parent::_prepareLayout();
    }

   	/**
     * Form element instance
     *
     * @var Varien_Data_Form_Element_Abstract
     */
    protected $_element;

    /**
     * Customer groups cache
     *
     * @var array
     */
    protected $_customerGroups;

    /**
     * Websites cache
     *
     * @var array
     */
    protected $_websites;

    /**
     * Render HTML
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
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

    /**
     * Prepare group price values
     *
     * @return array
     */
    public function getValues()
    {
        $values = array();

        $financierId = Mage::app()->getRequest()->getParam('id');
        $data = Mage::getModel('forex/tiercommission')->getCollection()->addFieldToFilter('financier_id', $financierId)->getData();

        if (is_array($data)) {
            $values = $this->_sortValues($data);
        }

        return $values;
    }

    /**
     * Sort values
     *
     * @param array $data
     * @return array
     */
    protected function _sortValues($data)
    {
        return $data;
    }

    /**
     * Retrieve allowed customer groups
     *
     * @param int|null $groupId  return name by customer group id
     * @return array|string
     */
    public function getCustomerGroups($groupId = null)
    {

        if ($this->_customerGroups === null) {
            if (!Mage::helper('catalog')->isModuleEnabled('Mage_Customer')) {
                return array();
            }
            $collection = Mage::getModel('customer/group')->getCollection();
            $this->_customerGroups = $this->_getInitialCustomerGroups();

            foreach ($collection as $item) {
                /** @var $item Mage_Customer_Model_Group */
                $this->_customerGroups[$item->getId()] = $item->getCustomerGroupCode();
            }
        }

        if ($groupId !== null) {
            return isset($this->_customerGroups[$groupId]) ? $this->_customerGroups[$groupId] : array();
        }
        return $this->_customerGroups;
    }

    /**
     * Retrieve list of initial customer groups
     *
     * @return array
     */
    protected function _getInitialCustomerGroups()
    {
        return array(Mage_Customer_Model_Group::CUST_GROUP_ALL => Mage::helper('catalog')->__('ALL GROUPS'));
    }

    /**
     * Retrieve default value for customer group
     *
     * @return int
     */
    public function getDefaultCustomerGroup()
    {
        return Mage_Customer_Model_Group::CUST_GROUP_ALL;
    }

    /**
     * Retrieve 'add group price item' button HTML
     *
     * @return string
     */
    public function getAddButtonHtml()
    {
        return $this->getChildHtml('add_button');
    }

    /**
     * Retrieve customized price column header
     *
     * @param string $default
     * @return string
     */
    public function getPriceColumnHeader($default)
    {
        if ($this->hasData('price_column_header')) {
            return $this->getData('price_column_header');
        } else {
            return $default;
        }
    }

    /**
     * Retrieve customized price column header
     *
     * @param string $default
     * @return string
     */
    public function getPriceValidation($default)
    {
        if ($this->hasData('price_validation')) {
            return $this->getData('price_validation');
        } else {
            return $default;
        }
    }
}
