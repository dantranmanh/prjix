<?php

class Hxtech_Logistic_Block_Adminhtml_Pallet_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('pallet_form', array(
            'legend' => Mage::helper('logistic')->__('Pallet information')
        ));

        if (Mage::registry('pallet_data')) {
            $data = Mage::registry('pallet_data')->getData();
        }

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('logistic')->__('Name'),
            'required' => TRUE,
            'name' => 'name',
        ));

        $fieldset->addField('width', 'text', array(
            'label' => Mage::helper('logistic')->__('Width (mm)'),
            'required' => TRUE,
            'name' => 'width',
        ));

        $fieldset->addField('length', 'text', array(
            'label' => Mage::helper('logistic')->__('Length (mm)'),
            'required' => TRUE,
            'name' => 'length',
        ));

        $fieldset->addField('height', 'text', array(
            'label' => Mage::helper('logistic')->__('Height (mm)'),
            'required' => TRUE,
            'name' => 'height',
        ));

        $fieldset->addField('number_fit_small_container', 'text', array(
            'label' => Mage::helper('logistic')->__('Number pallet fit in 20ft container'),
            'required' => TRUE,
            'name' => 'number_fit_small_container',
        ));

        $fieldset->addField('number_fit_large_container', 'text', array(
            'label' => Mage::helper('logistic')->__('Number pallet fit in 40ft container'),
            'required' => TRUE,
            'name' => 'number_fit_large_container',
        ));

        $form->setValues($data);
        return parent::_prepareForm();
    }
}