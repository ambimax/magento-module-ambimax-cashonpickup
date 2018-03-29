<?php

class Ambimax_CashOnPickup_Test_SaveOrderTest extends EcomDev_PHPUnit_Test_Case
{
    public function testIfObserverExists()
    {
        $this->assertInstanceOf(
            Ambimax_CashOnPickup_Model_Observer::class,
            Mage::getSingleton('ambimax_cashonpickup/observer')
        );
    }

    /**
     * @loadFixture ~Ambimax_CashOnPickup/default
     */
    public function testChangeShippingAddressOnOrderSave()
    {
        /** @var Mage_Sales_Model_Order $order */
        $order = Mage::getModel('sales/order')->load(328);

        $observerMock = $this->getMockBuilder('Varien_Event_Observer')
            ->setMethods(['getOrder'])
            ->getMock();

        $observerMock
            ->expects($this->once())
            ->method('getOrder')
            ->willReturn($order);

        /** @var Ambimax_CashOnPickup_Model_Observer $observer */
        $observer = Mage::getSingleton('ambimax_cashonpickup/observer');
        $observer->changeShippingAddressOnPickup($observerMock);

        $shippingAddress = $order->getShippingAddress();

        $this->assertSame(
            'AnyCompany AG, Deborah Jane, Laupenstrasse 33, 3008 Bern',
            $shippingAddress->toString('{{company}}, {{firstname}} {{lastname}}, {{street}}, {{postcode}} {{city}}')
        );
    }
}


