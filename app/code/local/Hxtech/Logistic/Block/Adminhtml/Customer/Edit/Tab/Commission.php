<?php

class Hxtech_Logistic_Block_Adminhtml_Customer_Edit_Tab_Commission extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $customer = Mage::registry('current_customer');
        $model = Mage::getModel('logistic/importerconfig')->load($customer->getId(), 'importer_user_id');
        $form->setHtmlIdPrefix('user_');
        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Tier Commission')));
        $isAdminUser = Mage::helper('logistic/logistic')->isAdminUser();

        if($isAdminUser){
            $fieldset->addField('commission_status', 'select', array(
                'label' => Mage::helper('logistic')->__('Status'),
                'name' => 'commission_status',
                'values' => array(
                    array('value' => 1, 'label' => Mage::helper('logistic')->__('Enabled'),),
                    array('value' => 2, 'label' => Mage::helper('logistic')->__('Disabled'),)
                ,)
            ,));

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
        }else{
            $fieldset->addField('commission_type', 'select', array(
                'name'      => 'commission_type',
                'label'     => Mage::helper('adminhtml')->__('Commission Algorithm'),
                'readonly'  => true,
                'options'   => array(
                    Hxtech_Logistic_Model_Logistic::COMMISSION_FIXED_TYPE => Mage::helper('adminhtml')->__('Fixed Fee (FF)'),
                    Hxtech_Logistic_Model_Logistic::COMMISSION_PERCENTAGE_TYPE => Mage::helper('adminhtml')->__('Percentage (CM)'),
                    Hxtech_Logistic_Model_Logistic::COMMISSION_COMPARISON_TYPE => Mage::helper('adminhtml')->__('Greater of FF or CM'),
                ),
            ));

            $fieldset->addField('commission_fixed_fee', 'text', array(
                'name'  => 'commission_fixed_fee',
                'readonly' => true,
                'label' => Mage::helper('adminhtml')->__('Fixed Fee'),
                'title' => Mage::helper('adminhtml')->__('Fixed Fee'),
            ));

            $fieldset->addField('commission_percentage_fee', 'text', array(
                'name'  => 'commission_percentage_fee',
                'readonly' => true,
                'label' => Mage::helper('adminhtml')->__('Percentage Fee'),
                'title' => Mage::helper('adminhtml')->__('Percentage Fee'),
            )); 
        } 

        $tierCommissionField = $fieldset->addField('tier_commission', 'text', array(
            'name'  => 'tier_commission',
            'label' => Mage::helper('adminhtml')->__('Tier Commission')
        ));

        $tierCommissionField->setRenderer(
            $this->getLayout()->createBlock('logistic/adminhtml_customer_edit_renderer_tier')
        );

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}