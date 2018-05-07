<?php

class Ambimax_CashOnPickup_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     * @return bool|void
     * @throws Varien_Exception
     */
    public function changeShippingAddressOnPickup(Varien_Event_Observer $observer)
    {
        if ( !Mage::getStoreConfigFlag('payment/ambimax_cashonpickup/rewrite_shipping_adress_enabled') ) {
            return false;
        }
        
        /** @var Mage_Sales_Model_Order $order */
        $order = $observer->getOrder();

        if ( $order->getShippingMethod() !== 'ambimax_cashonpickup_standard' ) {
            return;
        }

        $storeId = $order->getStore();
        $shippingAddress = $order->getShippingAddress();

        $shippingAddress
            ->setCompany($this->getImprintValue('company_first', $storeId))
            ->setFirstname($shippingAddress->getFirstname())
            ->setLastname($shippingAddress->getLastname())
            ->setStreet($this->getImprintValue('street', $storeId))
            ->setCity($this->getImprintValue('city', $storeId))
            ->setPostcode($this->getImprintValue('zip', $storeId));
    }

    /**
     * @param $path
     * @param $storeId
     * @return mixed
     */
    public function getImprintValue($path, $storeId)
    {
        return Mage::getStoreConfig('general/imprint/' . $path, $storeId);
    }
}
