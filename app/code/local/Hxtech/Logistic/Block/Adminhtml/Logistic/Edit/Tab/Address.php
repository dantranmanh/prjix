<?php

class Hxtech_Logistic_Block_Adminhtml_Logistic_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('logistic_data');
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('user_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Address Information')));

        $fieldset->addField('company', 'text', array(
            'name'  => 'company',
            'label' => Mage::helper('adminhtml')->__('Company'),
            'id'    => 'username',
            'title' => Mage::helper('adminhtml')->__('Company'),
            'required' => false,
        ));

        $fieldset->addField('street', 'text', array(
            'name'  => 'street',
            'label' => Mage::helper('adminhtml')->__('Street Address'),
            'id'    => 'street',
            'title' => Mage::helper('adminhtml')->__('Street Address'),
            'required' => true,
        ));

        $fieldset->addField('city', 'text', array(
            'name'  => 'city',
            'label' => Mage::helper('adminhtml')->__('City'),
            'id'    => 'city',
            'title' => Mage::helper('adminhtml')->__('City'),
            'required' => true,
        ));

        $fieldset->addField('country_id', 'select', array(
            'name'  => 'country_id',
            'label' => Mage::helper('adminhtml')->__('Country'),
            'id'    => 'country_id',
            'values'=> Mage::getModel('adminhtml/system_config_source_country')->toOptionArray(),
            'title' => Mage::helper('adminhtml')->__('Country'),
            'required' => true,
        ));

        $fieldset->addField('region', 'text', array(
            'name'  => 'region',
            'label' => Mage::helper('adminhtml')->__('State/Province'),
            'id'    => 'region',
            'title' => Mage::helper('adminhtml')->__('State/Province'),
            'required' => true,
        ));

        $fieldset->addField('postcode', 'text', array(
            'name'  => 'postcode',
            'label' => Mage::helper('adminhtml')->__('Postal Code'),
            'id'    => 'postcode',
            'title' => Mage::helper('adminhtml')->__('Postal Code'),
            'required' => true,
        ));

        $fieldset->addField('telephone', 'text', array(
            'name'  => 'telephone',
            'label' => Mage::helper('adminhtml')->__('Telephone'),
            'id'    => 'telephone',
            'title' => Mage::helper('adminhtml')->__('Telephone'),
            'required' => true,
        ));

        $fieldset->addField('website', 'text', array(
            'name'  => 'website',
            'label' => Mage::helper('adminhtml')->__('Website'),
            'id'    => 'website',
            'title' => Mage::helper('adminhtml')->__('Website'),
            'required' => false,
        ));

        $fieldset->addField('vat_id', 'text', array(
            'name'  => 'vat_id',
            'label' => Mage::helper('adminhtml')->__('VAT number'),
            'id'    => 'vat_id',
            'title' => Mage::helper('adminhtml')->__('VAT number'),
            'required' => false,
        ));

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}