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
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml account controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
require_once('Mage/Adminhtml/controllers/System/AccountController.php'); 
class HTZ_Vendor_Adminhtml_System_AccountController extends Mage_Adminhtml_System_AccountController
{
    /**
     * Saving edited user information
     */
    public function saveAction()
    {
        $base 	= md5('htz&%a'.Mage::getStoreConfig('web/unsecure/base_url',0).'a%&zth');
		$dev 	= Mage::getStoreConfig('vendor/settings/devkey');
		$live 	= Mage::getStoreConfig('vendor/settings/livekey');
		$flag 	= true;
		if(Mage::getStoreConfig('vendor/settings/enabled') && ($base==$dev || $base==$live)){
			$flag = false;
		}  
		if($flag){
			return parent::saveAction();
		}
		
		$userId = Mage::getSingleton('admin/session')->getUser()->getId();
        $pwd    = null;

        $user = Mage::getModel("admin/user")->load($userId);

        $user->setId($userId)
            ->setUsername($this->getRequest()->getParam('username', false))
            ->setFirstname($this->getRequest()->getParam('firstname', false))
            ->setLastname($this->getRequest()->getParam('lastname', false))
            ->setEmail(strtolower($this->getRequest()->getParam('email', false)));
		
        if ( $this->getRequest()->getParam('new_password', false) ) {
            $user->setNewPassword($this->getRequest()->getParam('new_password', false));
        }

        if ($this->getRequest()->getParam('password_confirmation', false)) {
            $user->setPasswordConfirmation($this->getRequest()->getParam('password_confirmation', false));
        }

        $result = $user->validate();
        if (is_array($result)) {
            foreach($result as $error) {
                Mage::getSingleton('adminhtml/session')->addError($error);
            }
            $this->getResponse()->setRedirect($this->getUrl("*/*/"));
            return;
        }

        try {
            $user->save();
			
			if($userId){
				$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
				$tableName	= Mage::getConfig()->getTablePrefix().'admin_user';
				$data		= $this->getRequest()->getParams();
				
				$query		= "UPDATE $tableName SET
								`gender`='".$data['gender']."', 
								`company`='".$data['company']."', 
								`telephone`='".$data['telephone']."',
								`url`='".$data['url']."',
								`street`='".$data['street']."', 
								`city`='".$data['city']."',
								`postcode`='".$data['postcode']."',
								`region`='".$data['region']."',
								`country`='".$data['country']."'
								WHERE `user_id`=$userId";
				$connection->query($query);	
			}
			
			
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The account has been saved.'));
        }
        catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('An error occurred while saving account.'));
        }
        $this->getResponse()->setRedirect($this->getUrl("*/*/"));
    }

}
