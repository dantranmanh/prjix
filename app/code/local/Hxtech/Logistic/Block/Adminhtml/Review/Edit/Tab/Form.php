<?php

class Hxtech_Logistic_Block_Adminhtml_Review_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('review_data');
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Review Information')));

        $isReadOnly = $this->isReadOnly();

        $fieldset->addField('summary', 'text', array(
            'name'      => 'summary',
            'label'     => Mage::helper('adminhtml')->__('Summary'),
            'id'        => 'summary',
            'title'     => Mage::helper('adminhtml')->__('Summary'),
            'disabled'  => $isReadOnly,
            'required'  => true
        ));

        $fieldset->addField('review', 'textarea', array(
            'name'      => 'review',
            'label'     => Mage::helper('adminhtml')->__('Review'),
            'id'        => 'review',
            'title'     => Mage::helper('adminhtml')->__('Review'),
            'disabled'  => $isReadOnly,
            'required'  => true
        ));

        $fieldset->addField('number_star', 'select', array(
            'name'      => 'number_star',
            'label'     => Mage::helper('adminhtml')->__('Number Star'),
            'id'        => 'number_star',
            'title'     => Mage::helper('adminhtml')->__('Number Star'),
            'class'     => 'input-select',
            'style'     => 'width: 80px',
            'disabled'  => $isReadOnly,
            'options'   => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5
            )
        ));

        $data = $model->getData();
        $form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Is read only
     *
     * @return bool
     */
    public function isReadOnly()
    {
        /** @var Mage_Admin_Model_User $aclUser */
        $aclUser = Mage::getSingleton('admin/session')->getUser();
        if ($aclUser && $aclUser->getId()) {
            $role = $aclUser->getRole();

            if ($role->getRoleName() == 'Administrators') {
                return false;
            }
        }

        return true;
    }
}