<?php

class Ambimax_CashOnPickup_Model_Carrier_Pickup
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    protected $_code = 'ambimax_cashonpickup';

    /**
     * Collect rates
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        /** @var Mage_Shipping_Model_Rate_Result $result */
        $result = Mage::getModel('shipping/rate_result');
        $result->append($this->_getStandardRate());

        return $result;
    }

    /**
     * Returns standard rate
     *
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    protected function _getStandardRate()
    {
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('standard');
        $rate->setMethodTitle($this->getConfigData('method_title'));
        $rate->setPrice($this->getConfigData('price'));
        $rate->setCost(0);
        
        return $rate;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array($this->_code => 'Pickup');
    }

    /**
     * There is no tracking available
     *
     * @return bool
     */
    public function isTrackingAvailable()
    {
        return false;
    }
}