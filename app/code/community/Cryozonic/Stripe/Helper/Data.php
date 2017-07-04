<?php
/**
 * Cryozonic
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Single Domain License
 * that is available through the world-wide-web at this URL:
 * http://cryozonic.com/licenses/stripe.html
 * If you are unable to obtain it through the world-wide-web,
 * please send an email to info@cryozonic.com so we can send
 * you a copy immediately.
 *
 * @category   Cryozonic
 * @package    Cryozonic_Stripe
 * @copyright  Copyright (c) Cryozonic Ltd (http://cryozonic.com)
 */

class Cryozonic_Stripe_Helper_Data extends Mage_Payment_Helper_Data
{
    public function getBillingAddress($quote = null)
    {
        $quote = $this->getSessionQuote();

        if (!empty($quote) && $quote->getItemsCount() > 0 && $quote->getBillingAddress())
            return $quote->getBillingAddress();

        return null;
    }

    public function getSessionQuote()
    {
        // If we are in the back office
        if (Mage::app()->getStore()->isAdmin())
        {
            return Mage::getSingleton('adminhtml/sales_order_create')->getQuote();
        }
        // If we are a user
        return Mage::getSingleton('checkout/session')->getQuote();
    }

    public function getSanitizedBillingInfo()
    {
        $billingAddress = $this->getBillingAddress();
        if (!$billingAddress) return null;

        $postcode = $billingAddress->getData('postcode');
        $email = $billingAddress->getEmail();

        if (empty($email))
        {
            if (Mage::getSingleton('customer/session')->isLoggedIn())
            {
                $customer = Mage::getSingleton('customer/session')->getCustomer();
                $email = $customer->getEmail();
            }
            else
            {
                $quote = $this->getSessionQuote();
                if ($quote)
                    $email = $quote->getCustomerEmail();
            }
        }

        $street = explode('\n', $billingAddress->getData('street'));
        if (!empty($street) && is_array($street) && count($street))
            $line1 = $street[0];
        else
            $line1 = null;

        // Sanitization
        $line1 = preg_replace("/\r|\n/", " ", $line1);
        $line1 = addslashes($line1);
        if (empty($line1))
            $line1 = null;

        return array(
            'line1' => $line1,
            'postcode' => $postcode,
            'email' => $email
        );
    }

    // Removes decorative strings that Magento adds to the transaction ID
    public function cleanToken($token)
    {
        return preg_replace('/-.*$/', '', $token);
    }
}
