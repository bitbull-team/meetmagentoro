<?php

namespace Bitbull\MeetMagentoRo\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class SaveCheckboxInvoiceToOrderObserver
 * @package Bitbull\MeetMagentoRo\Observer
 */
class SaveCheckboxInvoiceToOrderObserver implements ObserverInterface
{
    /**
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(EventObserver $observer)
    {
        /** @var \Magento\Sales\Api\Data\OrderInterface $order */
        $order = $observer->getOrder();
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getQuote();

        $invoiceCheckbox = $quote->getShippingAddress()->getExtensionAttributes()->getInvoiceCheckbox();
        $order->setInvoiceCheckbox($invoiceCheckbox);
        return $this;
    }

}