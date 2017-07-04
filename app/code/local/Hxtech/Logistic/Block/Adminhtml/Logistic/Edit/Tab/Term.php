<?php

class Hxtech_Logistic_Block_Adminhtml_Logistic_Edit_Tab_Term extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Terms & Conditions')));

        $tierCommissionField = $fieldset->addField('term_condition', 'text', array(
            'name'  => 'term_condition',
            'label' => Mage::helper('adminhtml')->__('Terms & Conditions')
        ));

        $tierCommissionField->setRenderer(
            $this->getLayout()->createBlock('logistic/adminhtml_logistic_edit_renderer_term')
        );
        
        $this->setForm($form);

        return parent::_prepareForm();
    }
}