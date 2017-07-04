<?php

class Hxtech_Logistic_Block_Adminhtml_Import_Port_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('port_data');
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Port Information')));

        $fieldset->addField('country_code', 'select', array(
            'name'  => 'country_code',
            'label'     => Mage::helper('logistic')->__('Country'),
            'values'    => Mage::getModel('adminhtml/system_config_source_country')->toOptionArray(),
            'class' => 'required-entry',
            'required' => TRUE,
            'onchange' => 'hungdq()'
        ));

        $fieldset->addField('port', 'text', array(
            'name'  => 'port',
            'label' => Mage::helper('adminhtml')->__('Port'),
            'id'    => 'port',
            'title' => Mage::helper('adminhtml')->__('Port'),
            'required' => true,
        ));


        $data = $model->getData();
        $form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}