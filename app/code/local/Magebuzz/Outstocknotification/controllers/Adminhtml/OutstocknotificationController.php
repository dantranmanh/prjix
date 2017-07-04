<?php
/*
 * Copyright (c) 2014 www.magebuzz.com
 */
class Magebuzz_Outstocknotification_Adminhtml_OutstocknotificationController extends Mage_Adminhtml_Controller_action {
	protected function _initAction() {
		$this->loadLayout()
				->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		$this->_setActiveMenu('report/outstock');
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
				->renderLayout();
	}

	public function gridAction() {
		$this->loadLayout();
		$this->getResponse()->setBody($this->getLayout()->createBlock('outstocknotification/adminhtml_outstocknotification_grid')->toHtml());
	}

	public function alertsStockGridAction()
	{
		$this->loadLayout(false);
		$this->renderLayout();
	}

	public function massDeleteAction() {
		$_ids = $this->getRequest()->getParam('ids');
		if ($_ids) {
			$_deleted = 0;
			foreach ($_ids as $_id) {
				$_notification = Mage::getModel('productalert/stock')->load($_id);
				if ($_notification->getId()) {
					$_notification->delete();
					$_deleted++;
				}
			}

			if ($_deleted) {
				Mage::getSingleton('core/session')->addSuccess($this->__("Successfully deleted %d item(s)", $_deleted));
				$this->_redirect('*/*/index');
				return;
			}
		}
		Mage::getSingleton('core/session')->addError($this->__("There is problem when delete item(s)"));
		$this->_redirect('*/*/index');
		return;
	}
}