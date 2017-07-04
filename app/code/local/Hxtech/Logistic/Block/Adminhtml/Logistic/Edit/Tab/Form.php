<?php

class Hxtech_Logistic_Block_Adminhtml_Logistic_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('logistic_data');
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('user_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Logistic Information')));

        if ($model->getUserId()) {
            $fieldset->addField('user_id', 'hidden', array(
                'name' => 'user_id',
            ));
        }

        if (Mage::getSingleton('admin/session')->getUser()->getId() != $model->getUserId()) {
            $fieldset->addField('is_active', 'select', array(
                'name'      => 'is_active',
                'label'     => Mage::helper('adminhtml')->__('This account is'),
                'id'        => 'is_active',
                'title'     => Mage::helper('adminhtml')->__('Account Status'),
                'class'     => 'input-select',
                'style'     => 'width: 80px',
                'options'   => array('1' => Mage::helper('adminhtml')->__('Active'), '0' => Mage::helper('adminhtml')->__('Inactive')),
            ));
        }

        $fieldset->addField('username', 'text', array(
            'name'  => 'username',
            'label' => Mage::helper('adminhtml')->__('Username'),
            'id'    => 'username',
            'title' => Mage::helper('adminhtml')->__('Username'),
            'class' => 'validate-alphanum',
            'required' => true,
        ));

        $fieldset->addField('firstname', 'text', array(
            'name'  => 'firstname',
            'label' => Mage::helper('adminhtml')->__('First Name'),
            'id'    => 'firstname',
            'title' => Mage::helper('adminhtml')->__('First Name'),
            'required' => true,
        ));

        $fieldset->addField('lastname', 'text', array(
            'name'  => 'lastname',
            'label' => Mage::helper('adminhtml')->__('Last Name'),
            'id'    => 'lastname',
            'title' => Mage::helper('adminhtml')->__('Last Name'),
            'required' => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'  => 'email',
            'label' => Mage::helper('adminhtml')->__('Email'),
            'id'    => 'customer_email',
            'title' => Mage::helper('adminhtml')->__('User Email'),
            'class' => 'required-entry validate-email',
            'required' => true,
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
            'label'     => Mage::helper('adminhtml')->__('Description'),
            'title'     => Mage::helper('adminhtml')->__('Description'),
            'wysiwyg'   => true,
            'required'  => false,
            'config'    => $configSettings
        ));

        if ($model->getUserId()) {
            $fieldset->addField('password', 'password', array(
                'name'  => 'new_password',
                'label' => Mage::helper('adminhtml')->__('New Password'),
                'id'    => 'new_pass',
                'title' => Mage::helper('adminhtml')->__('New Password'),
                'class' => 'input-text validate-admin-password',
            ));

            $fieldset->addField('confirmation', 'password', array(
                'name'  => 'password_confirmation',
                'label' => Mage::helper('adminhtml')->__('Password Confirmation'),
                'id'    => 'confirmation',
                'class' => 'input-text validate-cpassword',
            ));
        }
        else {
            $fieldset->addField('password', 'password', array(
                'name'  => 'password',
                'label' => Mage::helper('adminhtml')->__('Password'),
                'id'    => 'customer_pass',
                'title' => Mage::helper('adminhtml')->__('Password'),
                'class' => 'input-text required-entry validate-admin-password',
                'required' => true,
            ));
            $fieldset->addField('confirmation', 'password', array(
                'name'  => 'password_confirmation',
                'label' => Mage::helper('adminhtml')->__('Password Confirmation'),
                'id'    => 'confirmation',
                'title' => Mage::helper('adminhtml')->__('Password Confirmation'),
                'class' => 'input-text required-entry validate-cpassword',
                'required' => true,
            ));
        }

        $fieldset->addField('logistic_logo', 'image', array(
            'name'  => 'logistic_logo',
            'label' => Mage::helper('adminhtml')->__('Logo'),
            'required' => false,
        ));

        $fieldset->addField('company_position', 'text', array(
            'name'  => 'company_position',
            'label' => Mage::helper('adminhtml')->__('Position in the company'),
            'id'    => 'company_position',
            'title' => Mage::helper('adminhtml')->__('Position in the company'),
            'required' => false,
        ));

        $fieldset->addField('telephone', 'text', array(
            'name'  => 'telephone',
            'label' => Mage::helper('adminhtml')->__('Telephone number'),
            'id'    => 'telephone',
            'title' => Mage::helper('adminhtml')->__('Telephone number'),
            'required' => false,
        ));

        $fieldset->addField('bank_account_number', 'text', array(
            'name'  => 'bank_account_number',
            'label' => Mage::helper('adminhtml')->__('Bank account number'),
            'id'    => 'bank_account_number',
            'title' => Mage::helper('adminhtml')->__('Bank account number'),
            'required' => false,
        ));

        $fieldset->addField('sort_code', 'text', array(
            'name'  => 'sort_code',
            'label' => Mage::helper('adminhtml')->__('Sort Code/ BSB'),
            'id'    => 'sort_code',
            'title' => Mage::helper('adminhtml')->__('Sort Code/ BSB'),
            'required' => false,
        ));

        $data = $model->getData();
        $logo = $data['logistic_logo'];
        if($logo != ''){
            $data['logistic_logo'] = 'logistic'.DS.'logo'.DS.$logo;
        }

        unset($data['password']);

        $form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}