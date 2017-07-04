<?php

class Hxtech_Forex_Block_Adminhtml_Financier_Edit_Tab_Commission extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $model = Mage::registry('financier_data');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('forex')->__('Tier Commission')));

        $fieldset->addField('commission_type', 'select', array(
            'name'      => 'commission_type',
            'label'     => Mage::helper('forex')->__('Commission Algorithm'),
            'options'   => array(
                Hxtech_Logistic_Model_Logistic::COMMISSION_FIXED_TYPE => Mage::helper('forex')->__('Fixed Fee (FF)'),
                Hxtech_Logistic_Model_Logistic::COMMISSION_PERCENTAGE_TYPE => Mage::helper('forex')->__('Percentage (CM)'),
                Hxtech_Logistic_Model_Logistic::COMMISSION_COMPARISON_TYPE => Mage::helper('forex')->__('Fixed minimum'),
            ),
        ));

        $fieldset->addField('commission_fixed_fee', 'text', array(
            'name'  => 'commission_fixed_fee',
            'label' => Mage::helper('forex')->__('Fixed Fee (FF)'),
            'title' => Mage::helper('forex')->__('Fixed Fee (FF)'),
        ));

        $fieldset->addField('commission_percentage_fee', 'text', array(
            'name'  => 'commission_percentage_fee',
            'label' => Mage::helper('forex')->__('Percentage (CM)'),
            'title' => Mage::helper('forex')->__('Percentage (CM)'),
        ));  

        $tierCommissionField = $fieldset->addField('tier_commission', 'text', array(
            'name'  => 'tier_commission',
            'label' => Mage::helper('forex')->__('Tier Commission')
        ));

        $tierCommissionField->setRenderer(
            $this->getLayout()->createBlock('forex/adminhtml_financier_edit_renderer_tier')
        );
        
        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}