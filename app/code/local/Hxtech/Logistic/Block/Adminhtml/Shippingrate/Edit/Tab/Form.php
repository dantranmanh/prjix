<?php

class Hxtech_Logistic_Block_Adminhtml_Shippingrate_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('shippingrate_form', array(
            'legend' => Mage::helper('logistic')->__('Shipping Rate information')
        ));

        if (Mage::registry('shippingrate_data')) {
            $data = Mage::registry('shippingrate_data')->getData();
        }

        $fieldset->addField('status', 'select', array(
                'label' => Mage::helper('logistic')->__('Status'),
                'name' => 'status',
                'values' => array(
                    array('value' => 1, 'label' => Mage::helper('logistic')->__('Enabled'),),
                    array('value' => 2, 'label' => Mage::helper('logistic')->__('Disabled'),)
                ,)
            ,)
        );

        $fieldset->addField('name_of_service', 'text', array(
            'label' => Mage::helper('logistic')->__('Name of service'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'name_of_service',
        ));

        $fieldset->addField('container_size', 'select', array(
            'label' => Mage::helper('logistic')->__('Container Size (ft)'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'container_size',
            'values' => Mage::helper('logistic/field')->getShippingRateOptions('container_size')
        ));

        $fieldset->addField('shipping_terms', 'select', array(
            'label' => Mage::helper('logistic')->__('Shipping Terms'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'shipping_terms',
            'values' => Mage::helper('logistic/field')->getShippingRateOptions('shipping_terms')
        ));

        $fieldset->addField('transport_method', 'select', array(
            'label' => Mage::helper('logistic')->__('Transport Method'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'transport_method',
            'values' => Mage::helper('logistic/field')->getShippingRateOptions('transport_method')
        ));

        $fieldset->addField('origin_port', 'multiselect', array(
            'label' => Mage::helper('logistic')->__('Origin'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'origin_port',
            'values' => Mage::helper('logistic/field')->getShippingRateOptions('origin_port')
        ));

        $fieldset->addField('destination_country', 'select', array(
            'name'  => 'destination_country',
            'label'     => Mage::helper('logistic')->__('Destination Country'),
            'values'    => Mage::getModel('adminhtml/system_config_source_country')->toOptionArray(),
            'class' => 'required-entry',
            'onchange' => "reloadCityFieldByCountry('".Mage::helper('adminhtml')->getUrl('logistic/adminhtml_shippingrate/reloadCityFieldByCountry')."', this)",
            'required' => TRUE
        ));
        
        if(isset($data['destination_country'])){
            $destinationCountry = $data['destination_country'];
        }else{
            $destinationCountry = "";
        }

        $fieldset->addField('destination_port', 'multiselect', array(
            'label' => Mage::helper('logistic')->__('Destination'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'destination_port',
            'values' => Mage::helper('logistic/field')->getPortOptions($destinationCountry)
        ));

        $fieldset->addField('container_specifications', 'select', array(
            'label' => Mage::helper('logistic')->__('Container Specifications'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'container_specifications',
            'values' => Mage::helper('logistic/field')->getShippingRateOptions('container_specifications')
        ));

        $fieldset->addField('transit_time', 'text', array(
            'label' => Mage::helper('logistic')->__('Transit Time'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'transit_time',
        ));

        $fieldset->addField('price_cbm', 'text', array(
            'label' => Mage::helper('logistic')->__('Price / CBM'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'price_cbm',
        ));

        $fieldset->addField('documentation_fee', 'text', array(
            'label' => Mage::helper('logistic')->__('Documentation Fee'),
            'class' => 'required-entry',
            'required' => TRUE,
            'name' => 'documentation_fee',
        ));
        
        $form->setValues($data);
        return parent::_prepareForm();
    }
}