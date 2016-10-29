<?php

namespace Bitbull\MeetMagentoRo\Plugin\Sales\Api;

/**
 * Class OrderRepositoryInterfacePlugin
 * @package Bitbull\MeetMagentoRo\Plugin\Sales\Api
 */
class OrderRepositoryInterfacePlugin
{

    /** @var \Magento\Sales\Api\Data\OrderExtensionFactory */
    protected $orderExtensionFactory;

    /**
     * Init plugin
     *
     * @param \Magento\Sales\Api\Data\OrderExtensionFactory $orderExtensionFactory
     */
    public function __construct(
        \Magento\Sales\Api\Data\OrderExtensionFactory $orderExtensionFactory
    ) {
        $this->orderExtensionFactory = $orderExtensionFactory;
    }

    /**
     *
     * @param \Magento\Sales\Api\OrderRepositoryInterface $subject
     * @param \Magento\Sales\Api\Data\OrderSearchResultInterface $result
     * @return \Magento\Sales\Api\Data\OrderSearchResultInterface
     */
    public function afterGetList(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Api\Data\OrderSearchResultInterface $result
    ) {
        foreach ($result->getItems() as $order) {
            $this->getInvoiceCheckExtensionAttribute($order);
        }
        return $result;
    }

    /**
     *
     * @param \Magento\Sales\Api\OrderRepositoryInterface $subject
     * @param \Magento\Sales\Api\Data\OrderInterface $result
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function afterGet(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Api\Data\OrderInterface $result
    ) {

        return $this->getInvoiceCheckExtensionAttribute($result);
    }

    /**
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    private function getInvoiceCheckExtensionAttribute($order)
    {
        /** @var \Magento\Sales\Api\Data\OrderExtensionInterface $extensionAttributes */
        $extensionAttributes = $order->getExtensionAttributes();

        if ($extensionAttributes && $extensionAttributes->getInvoiceCheckbox()) {
            return $order;
        }

        if (null === $extensionAttributes) {
            $extensionAttributes = $this->orderExtensionFactory->create();
        }

        $extensionAttributes->setInvoiceCheckbox($order->getInvoiceCheckbox());
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }
}