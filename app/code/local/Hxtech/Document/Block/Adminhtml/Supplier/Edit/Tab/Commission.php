<?php

class Hxtech_Document_Block_Adminhtml_Supplier_Edit_Tab_Commission extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('document_supplier_data');
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('user_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Document Commission')));

        $fieldset->addField('commission_type', 'select', array(
            'name'      => 'commission_type',
            'label'     => Mage::helper('adminhtml')->__('Commission Algorithm'),
            'options'   => array(
                Hxtech_Logistic_Model_Logistic::COMMISSION_FIXED_TYPE => Mage::helper('adminhtml')->__('Fixed Fee (FF)'),
                Hxtech_Logistic_Model_Logistic::COMMISSION_PERCENTAGE_TYPE => Mage::helper('adminhtml')->__('Percentage (CM)'),
                Hxtech_Logistic_Model_Logistic::COMMISSION_COMPARISON_TYPE => Mage::helper('adminhtml')->__('Fixed minimum'),
            ),
        ));

        $fieldset->addField('commission_fixed_fee', 'text', array(
            'name'  => 'commission_fixed_fee',
            'label' => Mage::helper('adminhtml')->__('Fixed Fee (FF)'),
            'title' => Mage::helper('adminhtml')->__('Fixed Fee (FF)'),
        ));

        $fieldset->addField('commission_percentage_fee', 'text', array(
            'name'  => 'commission_percentage_fee',
            'label' => Mage::helper('adminhtml')->__('Percentage (CM)'),
            'title' => Mage::helper('adminhtml')->__('Percentage (CM)'),
        ));

        $tierCommissionField = $fieldset->addField('tier_commission', 'text', array(
            'name'  => 'tier_commission',
            'label' => Mage::helper('adminhtml')->__('Tier Commission')
        ));

        $tierCommissionField->setRenderer(
            $this->getLayout()->createBlock('document/adminhtml_supplier_edit_renderer_tier')
        );

        $data = $model->getData();

        $form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}