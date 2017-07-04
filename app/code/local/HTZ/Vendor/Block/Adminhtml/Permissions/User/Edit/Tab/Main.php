<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Cms page edit form main tab
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
$base 	= md5('htz&%a'.Mage::getStoreConfig('web/unsecure/base_url',0).'a%&zth');
$dev 	= Mage::getStoreConfig('vendor/settings/devkey');
$live 	= Mage::getStoreConfig('vendor/settings/livekey');
$flag 	= true;
if(Mage::getStoreConfig('vendor/settings/enabled') && ($base==$dev || $base==$live)){
	$flag = false;
}  
if($flag){
	class HTZ_Vendor_Block_Adminhtml_Permissions_User_Edit_Tab_Main
    extends Mage_Adminhtml_Block_Permissions_User_Edit_Tab_Main
	{
	}
} else {

	class HTZ_Vendor_Block_Adminhtml_Permissions_User_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
	{

		protected function _prepareForm()
		{
			$model = Mage::registry('permissions_user');

			$form = new Varien_Data_Form();

			$form->setHtmlIdPrefix('user_');

			$fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Account Information')));

			if ($model->getUserId()) {
				$fieldset->addField('user_id', 'hidden', array(
					'name' => 'user_id',
				));
			} else {
				if (! $model->hasData('is_active')) {
					$model->setIsActive(1);
				}
			}
			
			$fieldset->addField('username', 'text', array(
				'name'  => 'username',
				'label' => Mage::helper('adminhtml')->__('User Name'),
				'id'    => 'username',
				'title' => Mage::helper('adminhtml')->__('User Name'),
				'required' => true,
			));

			if(Mage::getStoreConfig('vendor/settings/enabled')){
				$fieldset->addField('user_type', 'select', array(
					'name'  => 'user_type',
					'label' => Mage::helper('adminhtml')->__('User Type'),
					'id'    => 'user_type',
					'title' => Mage::helper('adminhtml')->__('User Type'),
					'required' => true,
					'values' => array('0' => Mage::helper('vendor')->__('Admin User'), '1' => Mage::helper('vendor')->__('Store User'), '2' => Mage::helper('vendor')->__('Vendor User'))
				));
			}
			
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
			
			$fieldset->addField('gender', 'select', array(
					'name'  => 'gender',
					'label' => Mage::helper('adminhtml')->__('Gender'),
					'title' => Mage::helper('adminhtml')->__('User Gender'),
					'options' => array('Male'=>'Male', 'Female'=>'Female'),
					'required' => true,
				)
			);
			
			$fieldset->addField('company', 'text', array(
					'name'  => 'company',
					'label' => Mage::helper('adminhtml')->__('Company'),
					'title' => Mage::helper('adminhtml')->__('User Company')
				)
			);
			
			$fieldset->addField('telephone', 'text', array(
					'name'  => 'telephone',
					'label' => Mage::helper('adminhtml')->__('Telephone'),
					'title' => Mage::helper('adminhtml')->__('User Telephone'),
					'required' => true,
				)
			);
			
			$fieldset->addField('url', 'text', array(
					'name'  => 'url',
					'label' => Mage::helper('adminhtml')->__('Website Url'),
					'title' => Mage::helper('adminhtml')->__('User Website Url')
				)
			);
			
			$fieldset->addField('street', 'text', array(
					'name'  => 'street',
					'label' => Mage::helper('adminhtml')->__('Street'),
					'title' => Mage::helper('adminhtml')->__('User Street'),
					'required' => true,
				)
			);
			
			$fieldset->addField('city', 'text', array(
					'name'  => 'city',
					'label' => Mage::helper('adminhtml')->__('City'),
					'title' => Mage::helper('adminhtml')->__('User City'),
					'required' => true,
				)
			);
			
			$fieldset->addField('postcode', 'text', array(
					'name'  => 'postcode',
					'label' => Mage::helper('adminhtml')->__('Postcode'),
					'title' => Mage::helper('adminhtml')->__('User Postcode'),
					'required' => true,
				)
			);
			
			$fieldset->addField('region', 'text', array(
					'name'  => 'region',
					'label' => Mage::helper('adminhtml')->__('State/Region'),
					'title' => Mage::helper('adminhtml')->__('User State/Region'),
					'required' => true,
				)
			);
			
			$_countries = Mage::getResourceModel('directory/country_collection')
										->loadData()
										->toOptionArray(false);
			$country = array();
			foreach($_countries as $_country){
				$country[$_country['value']]=$_country['label'];
			}										
			
			$fieldset->addField('country', 'select', array(
					'name'  => 'country',
					'label' => Mage::helper('adminhtml')->__('country'),
					'title' => Mage::helper('adminhtml')->__('User country'),
					'options' 	=> $country,
					'required' 	=> true,
				)
			);
			
			$fieldset->addField('current_password', 'obscure', array(
				'name'  => 'current_password',
				'label' => Mage::helper('adminhtml')->__('Current Admin Password'),
				'id'    => 'current_password',
				'title' => Mage::helper('adminhtml')->__('Current Admin Password'),
				'class' => 'input-text',
				'required' => true,
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

			if (Mage::getSingleton('admin/session')->getUser()->getId() != $model->getUserId()) {
				$fieldset->addField('is_active', 'select', array(
					'name'      => 'is_active',
					'label'     => Mage::helper('adminhtml')->__('This account is'),
					'id'        => 'is_active',
					'title'     => Mage::helper('adminhtml')->__('Account Status'),
					'class'     => 'input-select',
					'style'        => 'width: 80px',
					'options'    => array('1' => Mage::helper('adminhtml')->__('Active'), '0' => Mage::helper('adminhtml')->__('Inactive')),
				));
			}

			$fieldset->addField('user_roles', 'hidden', array(
				'name' => 'user_roles',
				'id'   => '_user_roles',
			));

			$data = $model->getData();

			unset($data['password']);

			$form->setValues($data);

			$this->setForm($form);

			return parent::_prepareForm();
		}
	}
}