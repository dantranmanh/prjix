<?php

class Hxtech_Document_Block_Adminhtml_Documentation_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array('id' => 'edit_form',
            'action' => $this->getUrl('*/*/save',
                array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post', 'enctype' => 'multipart/form-data'));

        $form->setUseContainer(TRUE);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}