<?php
/*
 * @Copyright (c) 2014 www.magebuzz.com
 */
class Magebuzz_Outstocknotification_IndexController extends Mage_Core_Controller_Front_Action {
	public function indexAction() {
		$this->loadLayout();
		$this->_initLayoutMessages('catalog/session');
		$this->renderLayout();
	}

	public function viewAction() {
		$this->loadLayout();
		$this->renderLayout();
	}

	public function popupnotifyAction() {
		$this->loadLayout();
		$this->renderLayout();
	}

	public function popuplistAction() {
		$this->loadLayout();
		$this->renderLayout();
	}

	public function stoctnotifyAction() {
		$successMessage = Mage::getStoreConfig('outstocknotification/general/success_message');
		$errorMessage = Mage::getStoreConfig('outstocknotification/general/error_message');
		$isArray = $this->getRequest()->getParams();
		$session = Mage::getModel('customer/session');
		if($session->isLoggedIn()) {
			$customer = $session->getCustomer()->getData();
			$isArray['customer_id']= $customer['entity_id'];
		} else {
			$isArray['customer_id']= 0;
		}
		$model = Mage::getModel('outstocknotification/outstocknotification')->addDataNotify($isArray);
		if($model) {
			echo '<div style="margin-top:30px;" id="messages_shoppinglist">
					<ul class="messages">
						<li class="success-msg">
							<ul>
								<li>
									<span>'.Mage::helper('outstocknotification')->__($successMessage).'</span>
								</li>
							</ul>
						</li>
					</ul>
				</div>';
		} else {
			echo '<div style="margin-top:30px;" id="messages_shoppinglist">
					<ul class="messages">
						<li class="error-msg">
							<ul>
								<li>
									<span>'.Mage::helper('outstocknotification')->__($errorMessage).'</span>
								</li>
							</ul>
						</li>
					</ul>
				</div>';
		}
		$this->loadLayout();
		$this->renderLayout();
	}

	public function viewstockAction() {
		$this->loadLayout();
		$this->_initLayoutMessages('core/session');
		$this->getLayout()->getBlock('head')->setTitle($this->__('My Out of Stock Subscriptions'));
		if ($block = $this->getLayout()->getBlock('customer.account.link.back')) {
			$block->setRefererUrl($this->_getRefererUrl());
		}
		$this->renderLayout();
	}

	public function deletenotifiAction() {
		$session = Mage::getSingleton('customer/session');
		if($session->isLoggedIn()) {
			$customer = $session->getCustomer()->getData();
			$notifi_id = $this->getRequest()->getParam('notifi_id');
			$deletenotifi = Mage::getModel('productalert/stock');
			$deletenotifi->load($notifi_id);
			$deletenotifi->delete();
			$this->_redirect('*/*/viewstock/');
		}
	}

	public function send_notify_stockAction() {
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		$product_id = $this->getRequest()->getParam('product_id');
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		if ($product_id && $customer->getId()) {
			try {
				$model = Mage::getModel('productalert/stock')
						->setCustomerId($customer->getId())
						->setFirstname($customer->getFirstname())
						->setLastname($customer->getLastname())
						->setEmail($customer->getEmail())
						->setProductId($product_id)
						->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
				$model->loadByParam();
				if ($model->getId()) {
					$this->getResponse()->setBody(json_encode(array(
							'success' 	=> true,
							'message' 	=> "Already subscribed",
					)));
					return;
				} else {
					$model->save();
					$this->getResponse()->setBody(json_encode(array(
							'success' => true
					)));
					return;
				}
			} catch (Exception $e) {
				$this->getResponse()->setBody(json_encode(array(
						'success' 	=> false,
						'message' 	=> $e->getMessage(),
				)));
				return;
			}
		}
		$this->getResponse()->setBody(json_encode(array(
				'success' 	=> false,
				'error' 	=> 'Invalid product or customer session',
		)));
		return;
	}

	public function sendNotifyAfterLoginAction() {
		$successMessage = Mage::getStoreConfig('outstocknotification/general/success_message');
		$errorMessage = Mage::getStoreConfig('outstocknotification/general/error_message');
		$isArray = $this->getRequest()->getParams();
		$session = Mage::getModel('customer/session');
		if($session->isLoggedIn()) {
			$customer = $session->getCustomer()->getData();
			$isArray['customer_id']= $customer['entity_id'];
			$isArray['email'] = $customer['email'];
		} else {
			die('false');
			//$isArray['customer_id']= 0;
		}
		$pName = Mage::getModel('catalog/product')->load($isArray['productid'])->getName();
		$model = Mage::getModel('outstocknotification/outstocknotification')->addDataNotifyAfterLogin($isArray);
		Mage::getSingleton('core/session')->addSuccess($pName.' was successfully added to your out of stock notifications');
		$this->_redirect('customer/account/index');
	}

  protected function _getCart()
  {
    return Mage::getSingleton('checkout/cart');
  }

  public function deleteItemCartAction(){
    $result = array();
    $id = (int)$this->getRequest()->getParam('id');
    $productId = (int)$this->getRequest()->getParam('productid');
    $_product = Mage::getModel('catalog/product')->load($productId);
    $manageStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product)->getManageStock();
    if ($manageStock == '1') {
      $stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product)->getQty();
      $result['stocklevel'] = $stocklevel;
      $result['managestock'] = 'true';
    }
    $_cart = Mage::getSingleton('checkout/cart');
    $items = $_cart->getQuote()->getAllItems();
    $numberItems = count($items) - 1;

    if ($id) {
      try {
        $this->_getCart()->removeItem($id)->save();

        $result['qty'] = $this->_getCart()->getSummaryQty();

        $this->loadLayout();
//        $result['content'] = $this->getLayout()->getBlock('minicart_content')->toHtml();

        $result['success'] = 1;
        $result['message'] = $this->__('Item was removed successfully.');
      } catch (Exception $e) {
        $result['success'] = 0;
        $result['error'] = $this->__('Can not remove the item.');
      }
    }
    $subtotal = Mage::helper('checkout/cart')->getQuote()->getSubtotal();
    $result['subtotal'] = Mage::helper('checkout')->formatPrice($subtotal);
    $result['counterblock'] = '.counter-' . $productId;
    $result['productid'] = $productId;
    $result['itemsqty'] = $numberItems;
    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    return;
  }

  public function updateCartAction(){
    $params = $this->getRequest()->getParams();
    $itemIds = explode("-", $params['itemIds']);
    $values = explode("-", $params['values']);
    $isShoppingCart = $params['in_shopping_cart'];
    $countSuccess = 0;
    $cart = $this->_getCart();
    try {
      foreach($itemIds as $key => $itemId){
        $qty = $values[$key];

        $quoteItem = $cart->getQuote()->getItemById($itemId);
        if (!$quoteItem) {
          Mage::throwException($this->__('Quote item is not found'));
        }
        $quoteItem->setQty($qty)->save();

        $countSuccess++;

        if (!$quoteItem->getHasError()) {
          $result['message'] = $this->__('Item was updated successfully.');
        } else {
          $result['notice'] = $quoteItem->getMessage();
        }
      }
      $this->_getCart()->save();
    } catch (Exception $e) {
    }
    $result['success'] = $countSuccess;
    $result['top_cart_html'] = '';

    $this->getResponse()->setHeader('Content-type', 'application/json');
    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    return;
  }
}