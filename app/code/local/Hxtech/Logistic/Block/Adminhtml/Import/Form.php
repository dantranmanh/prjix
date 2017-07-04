<?php

class Hxtech_Logistic_Block_Adminhtml_Import_Form extends Mage_Adminhtml_Block_Widget_Form 
{
	protected function _prepareForm()
	{
		$sampleCSVpath = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'logistic/import/Shippingrate.csv';

	    $form = new Varien_Data_Form(array(
	    	'id' => 'edit_form',
	    	'action' => $this->getUrl('*/adminhtml_import/save'),
	    	'method' => 'post',
	    	'enctype' => 'multipart/form-data'
    	));

	    $fieldset = $form->addFieldset('edit_form', array(
	    	'legend' => Mage::helper('logistic')->__('Import shipping rate via CSV file')
    	));

	    $fieldset->addField('csv_file', 'file', array(
	    	'name' => 'csv_file',
	    	'label' => $this->__('Choose CSV file to import'),
	    	'after_element_html' => Mage::helper('logistic')->__('<br/>A CSV file may contain many shipping rates (<a href="%s">Sample CSV file</a>)', $sampleCSVpath)
    	));

	    $form->setUseContainer(TRUE);
	    $this->setForm($form);;
	    return parent::_prepareForm();
	}	  
}