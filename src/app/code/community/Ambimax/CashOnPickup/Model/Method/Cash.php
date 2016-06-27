<?php

class Ambimax_CashOnPickup_Model_Method_Cash // extends Mage_Payment_Model_Method_Checkmo
    extends Mage_Payment_Model_Method_Abstract
{

    protected $_code  = 'ambimax_cashonpickup';

    /**
     * Cash payment only available on pickup shipping method
     *
     * @param Mage_Sales_Model_Quote $quote
     * @return bool
     */
    public function isAvailable($quote = null)
    {
        return parent::isAvailable($quote)
            && $quote instanceof Mage_Sales_Model_Quote
            && $quote->getShippingAddress()->getShippingMethod() == 'ambimax_cashonpickup_standard';
    }

    /**
     * Can always be used
     *
     * @param Mage_Sales_Model_Quote $quote
     * @param int|null $checksBitMask
     * @return bool
     */
    public function isApplicableToQuote($quote, $checksBitMask)
    {
        return true;
    }

}
