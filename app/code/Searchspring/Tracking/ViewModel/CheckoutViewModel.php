<?php
declare(strict_types=1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Searchspring\Tracking\Service\Config;
use Searchspring\Tracking\Service\CompositeOrderItemPriceResolver;
use Searchspring\Tracking\Service\CompositeSkuResolver;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class CheckoutViewModel
 *
 * This is view model for Checkout Success Page
 *
 * @package Searchspring\Tracking\ViewModel
 */
class CheckoutViewModel implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $getSearchspringSiteId;

    /**
     * @var CompositeOrderItemPriceResolver
     */
    private $priceResolver;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var CompositeSkuResolver
     */
    private $skuResolver;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * CheckoutViewModel constructor.
     *
     * @param Config $getSearchspringSiteId
     * @param CompositeOrderItemPriceResolver $priceResolver
     * @param Session $checkoutSession
     * @param CompositeSkuResolver $skuResolver
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Config $getSearchspringSiteId,
        CompositeOrderItemPriceResolver $priceResolver,
        Session $checkoutSession,
        CompositeSkuResolver $skuResolver,
        SerializerInterface $serializer
    ) {
        $this->getSearchspringSiteId = $getSearchspringSiteId;
        $this->priceResolver         = $priceResolver;
        $this->checkoutSession       = $checkoutSession;
        $this->skuResolver           = $skuResolver;
        $this->serializer            = $serializer;
    }

    /**
     * @return array|null
     */
    private function getOrderItems(): ?array
    {
        return $this->checkoutSession->getLastRealOrder()->getAllVisibleItems();
    }

    /**
     * @return string|null
     */
    public function getSearchspringSiteId(): ?string
    {
        return $this->getSearchspringSiteId->getSearchspringSiteId();
    }

    /**
     * @return string|null
     */
    public function getProducts(): ?string
    {
        $orderItems = $this->getOrderItems();
        foreach ($orderItems as $orderItem) {
            if (!is_null($orderItem->getParentItem())) {
                continue;
            }
            $products[] = [
                'price' => $this->priceResolver->getProductPrice($orderItem),
                'sku'   => $this->skuResolver->getProductSku($orderItem),
                'qty'   => $this->getProductQuantity($orderItem)
            ];
        }
        return $this->serializer->serialize($products);
    }

    /**
     * @param OrderItemInterface $orderItem
     * @return int|null
     */
    private function getProductQuantity(OrderItemInterface $orderItem): ?int
    {
        return (int)$orderItem->getQtyOrdered();
    }
}
