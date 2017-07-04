<?php

class Hxtech_Forex_Block_Adminhtml_Financier_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('financier_data');
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('forex')->__('Financier Information')));

        $fieldset->addField('name', 'text', array(
            'name'  => 'name',
            'label' => Mage::helper('forex')->__('Name'),
            'required' => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'  => 'email',
            'label' => Mage::helper('forex')->__('Email'),
            'required' => true,
            'class' => 'validate-email'
        ));

        $configSettings = Mage::getSingleton('cms/wysiwyg_config')->getConfig( 
            array( 
                'add_widgets' => false, 
                'add_variables' => false, 
                'add_images' => false, 
                'files_browser_window_url'=> $this->getBaseUrl().'admin/cms_wysiwyg_images/index/', 
            )
        ); 

        $fieldset->addField('description', 'editor', array(
            'name'      => 'description',
            'label'     => Mage::helper('forex')->__('Description'),
            'title'     => Mage::helper('forex')->__('Description'),
            'wysiwyg'   => true,
            'required'  => false,
            'config'    => $configSettings
        ));

        $fieldset->addField('exclude_countries', 'multiselect', array(
            'label' => Mage::helper('forex')->__('Exclude Countries'),
            'name' => 'exclude_countries',
            'values' => Mage::getModel('adminhtml/system_config_source_country')->toOptionArray()
        ));

        $fieldset->addField('logo', 'image', array(
            'name'  => 'logo',
            'label' => Mage::helper('forex')->__('Logo'),
            'required' => false,
        ));

        $fieldset->addField('email_template_id', 'select', array(
            'label' => Mage::helper('forex')->__('Email Template'),
            'required' => TRUE,
            'name' => 'email_template_id',
            'values' => $this->getTemplateOptions()
        ));

        $data = $model->getData();
        if($data && isset($data['logo'])){
            if($data['logo'] != ''){
                $data['logo'] = 'forex'.DS.'financier'.DS.'logo'.DS.$data['logo'];
            }
        }

        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getTemplateOptions()
    {
        $options = array();

        $options[0] = array("value" => "", "label" => "Please select an email template");

        $collection = Mage::getModel('core/email_template')->getCollection();
        foreach($collection as $item){
            array_push($options, array("value" => $item->getTemplateId(), "label" => $item->getTemplateCode()));
        }
        return $options;
    }

}