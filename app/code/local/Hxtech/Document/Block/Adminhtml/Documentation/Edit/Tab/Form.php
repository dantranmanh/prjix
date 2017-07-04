<?php

class Hxtech_Document_Block_Adminhtml_Documentation_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('documentation_form', array(
            'legend' => Mage::helper('document')->__('Documentation information')
        ));

        if (Mage::registry('documentation_data')) {
            $data = Mage::registry('documentation_data')->getData();
        }

        $fieldset->addField('status', 'select', array(
                'label' => Mage::helper('document')->__('Status'),
                'name' => 'status',
                'values' => array(
                    array('value' => 1, 'label' => Mage::helper('document')->__('Enabled'),),
                    array('value' => 2, 'label' => Mage::helper('document')->__('Disabled'),)
                ,)
            ,)
        );

        $fieldset->addField('name_of_service', 'text', array(
            'label' => Mage::helper('document')->__('Name of service'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'name_of_service',
        ));

        $fieldset->addField('product_type', 'multiselect', array(
            'label' => Mage::helper('document')->__('Product Type'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'product_type',
            'values' => Mage::helper('document/field')->getProducAttibuteOptions('product_type')
        ));

        $fieldset->addField('document_type', 'multiselect', array(
            'label' => Mage::helper('document')->__('Document Type'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'document_type',
            'values' => Mage::helper('document/field')->getDocumentationOptions('document_type')
        ));

        $fieldset->addField('exporting_country', 'multiselect', array(
            'name'  => 'exporting_country',
            'label' => Mage::helper('adminhtml')->__('Exporting Country'),
            'id'    => 'exporting_country',
            'values'=> Mage::getModel('adminhtml/system_config_source_country')->toOptionArray(),
            'title' => Mage::helper('adminhtml')->__('Exporting Country'),
            'required' => true,
        ));

        $fieldset->addField('importing_country', 'multiselect', array(
            'name'  => 'importing_country',
            'label' => Mage::helper('adminhtml')->__('Importing Country'),
            'id'    => 'importing_country',
            'values'=> Mage::getModel('adminhtml/system_config_source_country')->toOptionArray(),
            'title' => Mage::helper('adminhtml')->__('Importing Country'),
            'required' => true,
        ));

        $fieldset->addField('price', 'text', array(
            'label' => Mage::helper('document')->__('Price'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'price',
        ));

        $form->setValues($data);
        return parent::_prepareForm();
    }
}