<?php

class Hxtech_Logistic_Adminhtml_LogisticController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('logistic/items')->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }

    protected function _isAllowed(){
        return Mage::getSingleton('admin/session')->isAllowed('logistic/logistic');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('admin/user');

        if ($id) {
            $model->load($id);
            $data = Mage::getSingleton('adminhtml/session')->getFormData(TRUE);
            if (!empty($data)) {
                $model->setData($data);
            }
        }
        Mage::register('logistic_data', $model);
        $this->loadLayout();
        $this->_setActiveMenu('logistic/items');

        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(TRUE);

        $this->_addContent($this->getLayout()->createBlock('logistic/adminhtml_logistic_edit'))->_addLeft($this->getLayout()->createBlock('logistic/adminhtml_logistic_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_redirect('*/*/edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $data['is_logistic_user'] = 1;
            $id = $this->getRequest()->getParam('user_id');
            $model = Mage::getModel('admin/user')->load($id);
            if (isset($_FILES['logistic_logo']['name']) && $_FILES['logistic_logo']['name'] != '') {
                try {
                    //rename image in case image name has space
                    $image_name = $_FILES['logistic_logo']['name'];
                    $new_image_name = Mage::helper('logistic')->renameImage($image_name);

                    $uploader = new Varien_File_Uploader('logistic_logo');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(TRUE);
                    $uploader->setFilesDispersion(FALSE);

                    $path = Mage::getBaseDir('media') . DS . 'logistic' . DS . 'logo';
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }

                    if (!file_exists($path . DS . $new_image_name)) {
                        $uploader->save($path, $new_image_name);
                    }
                } catch (Exception $e) {
                    Mage::getSingleton('admin/session')->addError($e->getMessage());
                }
                $data['logistic_logo'] = $new_image_name;
            }
            if (isset($data['logistic_logo']['delete']) && $data['logistic_logo']['delete'] == 1) {
                $data['logistic_logo'] = '';
            }  elseif ($model->getLogisticLogo()) {
                $data['logistic_logo'] = $model->getLogisticLogo();
            }
            //Validate current admin password
            $model->setData($data);

            /*
             * Unsetting new password and password confirmation if they are blank
             */
            if ($model->hasNewPassword() && $model->getNewPassword() === '') {
                $model->unsNewPassword();
            }
            if ($model->hasPasswordConfirmation() && $model->getPasswordConfirmation() === '') {
                $model->unsPasswordConfirmation();
            }

            try {
                $model->save();
                // Assign Logistic Role For Logistic User - HungDQ
                $uRoles = array(Mage::helper('logistic/logistic')->getLogisticRoleId());
                $model->setRoleIds($uRoles)
                    ->setRoleUserId($model->getUserId())
                    ->saveRelations();

                if($data['is_active'] == 1){
                   Mage::helper('logistic/logistic')->generateLogisticCmsPage($model);
                }

                if(isset($data['tier_commission']) && $model->getId()){
                    foreach($data['tier_commission'] as $tierCommission){
                        $tierModel = Mage::getModel('logistic/tiercommission');
                        if($tierCommission['delete'] == ''){
                            $tierModel->saveTierCommission($tierCommission, $model->getId());
                        }else{
                            $tierModel->deleteTierCommission($tierCommission);
                        }
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The logistic user has been saved.'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('admin/user');
                $model->setId($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The logistic user has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('user_id' => $this->getRequest()->getParam('user_id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find a logistic user to delete.'));
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $logisticIds = $this->getRequest()->getParam('logistic');
        if (!is_array($logisticIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($logisticIds as $logisticId) {
                    $logistic = Mage::getModel('logistic/logistic')->load($logisticId);
                    $logistic->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($logisticIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction()
    {
        $logisticIds = $this->getRequest()->getParam('logistic');
        if (!is_array($logisticIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($logisticIds as $logisticId) {
                    Mage::getSingleton('logistic/logistic')->load($logisticId)->setStatus($this->getRequest()->getParam('status'))->setIsMassupdate(TRUE)->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully updated', count($logisticIds)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function orderTabAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('logistic.edit.tab.order')
            ->setOrders($this->getRequest()->getPost('oorder', null));
        $this->renderLayout();
    }

    public function exportVolumetricAction()
    {
        $customerId = $this->getRequest()->getParam('customerId');
        $collection = Mage::getModel('sales/quote')->getCollection()->addFieldToFilter('customer_id', $customerId)->addFieldToFilter('is_active', 1);
        $currentQuote = $collection->getFirstItem();
        if (count($currentQuote->getData()) > 0) {
            $fileName   = 'cart.csv';
            $content    = Mage::getModel('logistic/csv_cart')->getCsv($currentQuote);
            $this->_prepareDownloadResponse($fileName, $content);
        } 
    }

    public function exportOrderHistoryPdfAction()
    {
        $logisticId = $this->getRequest()->getParam('logisticId');
        $logistic = Mage::getModel('admin/user')->load($logisticId);
        try {
            $pdf = Mage::getModel('logistic/pdf_logistic')->getPdf(array($logistic));
            $name = Mage::helper('logistic')->__('Freight Forwarder') . '.pdf';
            $this->_prepareDownloadResponseV2($name, $pdf->render(), 'application/pdf');
        } catch (Exception $ex) {
            Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
            $this->_redirect('logistic/adminhtml_logistic/index');
        }
    }

    /**
     * Custom download response method for magento multi version compatibility
     */
    protected function _prepareDownloadResponseV2($fileName, $content, $contentType = 'application/octet-stream') {
        $this->getResponse()
                ->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                ->setHeader('Content-type', $contentType, true)
                ->setHeader('Content-Length', strlen($content))
                ->setHeader('Content-Disposition', 'attachment; filename=' . $fileName)
                ->setBody($content);
    }

    /*
    * #119 - HungDQ - Send Order History Email function
    */
    public function sendOrderHistoryEmailAction()
    {
        $logisticId = $this->getRequest()->getParam('logisticId');
        $logistic = Mage::getModel('admin/user')->load($logisticId);
        try {
            // Generate order history pdf file
            $pdf = Mage::getModel('logistic/pdf_logistic')->getPdf(array($logistic));

            $emailTemplate = Mage::getModel('core/email_template');
            $mailer = Mage::getModel('core/email_template_mailer');
            if ($pdf) {
                $mailer->addAttachment($emailTemplate, $pdf, 'order_history.pdf');
            }
            $emailTemplate->sendTransactional(
                Mage::getStoreConfig('logistic/supplier/order_history_template'),
                Mage::getStoreConfig('sales_email/order/identity', 0),
                $logistic->getEmail(),
                $logistic->getUsername(),
                array()
            );
            $this->_getSession()->addSuccess($this->__('Order history email has been successfully sent'));
        } catch (Exception $ex) {
            $this->_getSession()->addError($ex->getMessage());
        }
        $this->_redirect('*/*/index');
    }
}