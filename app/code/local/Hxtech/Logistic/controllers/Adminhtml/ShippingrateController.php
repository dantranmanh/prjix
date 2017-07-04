<?php

class Hxtech_Logistic_Adminhtml_ShippingrateController extends Mage_Adminhtml_Controller_Action
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
        return true;
//        return Mage::getSingleton('admin/session')->isAllowed('logistic/shippingrate');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('logistic/shippingrate');

        if ($id) {
            $model->load($id);
            $data = Mage::getSingleton('adminhtml/session')->getFormData(TRUE);
            if (!empty($data)) {
                $model->setData($data);
            }
        }
        Mage::register('shippingrate_data', $model);
        $this->loadLayout();
        $this->_setActiveMenu('logistic/items');

        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(TRUE);

        $this->_addContent($this->getLayout()->createBlock('logistic/adminhtml_shippingrate_edit'))->_addLeft($this->getLayout()->createBlock('logistic/adminhtml_shippingrate_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_redirect('*/*/edit');
    }

    public function saveAction()
    {
        $r = $this->getRequest();
        if ($data = $r->getPost()) {
            if(isset($data['selected_logistic'])){
                $data['logistic_user_id'] = $data['selected_logistic'][0];
            }

            if(Mage::helper('logistic/logistic')->isLogisticUser()){
                $data['logistic_user_id'] = Mage::getSingleton('admin/session')->getUser()->getId();
            }
            // globo edit
            if(is_array($data['origin_port']))
                $data['origin_port'] = implode(',',$data['origin_port']);
            if(is_array($data['destination_port']))
                $data['destination_port'] = implode(',',$data['destination_port']);
            //# globo edit
            $model = Mage::getModel('logistic/shippingrate');
            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
                $model->setData($data)->setId($this->getRequest()->getParam('id'));
            }else{
                $model->setData($data);
            }

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Shipping rate was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(FALSE);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('logistic')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('logistic/shippingrate');

                $model->setId($this->getRequest()->getParam('id'))->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
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
                    $logistic = Mage::getModel('logistic/shippingrate')->load($logisticId);
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
                    Mage::getSingleton('logistic/shippingrate')->load($logisticId)->setStatus($this->getRequest()->getParam('status'))->setIsMassupdate(TRUE)->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully updated', count($logisticIds)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function logisticTabAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('shippingrate.edit.tab.logistic')
            ->setLogistics($this->getRequest()->getPost('ologistic', null));
        $this->renderLayout();
    }

    public function reloadCityFieldByCountryAction()
    {
        $result = array();
        $html = '';
        $html .= '<select id="destination_port" name="destination_port[]" class="required-entry required-entry select multiselect" size="10" multiple="multiple">';
        $html .= '<option value="">Please select an option</option>';
        $_params = $this->getRequest()->getParams();
        $countryCode = $_params['countryCode'];
        $collection = Mage::getModel('logistic/port')->getCollection()->addFieldToFilter('country_code', $countryCode);
        foreach($collection as $item){
            $html .= '<option value="'.$item->getPort().'">'.$item->getPort().'</option>';
        }
        $html .= '</select>';
        $result['html'] = $html;
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}