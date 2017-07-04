<?php

class Hxtech_Logistic_Adminhtml_TermController extends Mage_Adminhtml_Controller_Action
{
	public function submitPostAction()
	{
		$currentAdminUserId = Mage::getSingleton('admin/session')->getUser()->getId();
		$model = Mage::getModel('admin/user')->load($currentAdminUserId)->setTermStatus(1)->setTermTime(date('Y-m-d H:i:s'));
		try {
			$model->save();
		} catch (Exception $e) {

		}
	}

	protected function _isAllowed(){
        return true;
    }
}