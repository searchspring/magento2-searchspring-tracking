<?php
declare(strict_types=1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Searchspring\Tracking\Service\Config;
use Searchspring\Tracking\Service\OrderItemPriceResolver;
use Searchspring\Tracking\Service\SkuResolver;
use Magento\Framework\Serialize\SerializerInterface;

class CheckoutViewModel implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $getSearchspringSiteId;

    /**
     * @var OrderItemPriceResolver
     */
    private $priceResolver;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var SkuResolver
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
     * @param OrderItemPriceResolver $priceResolver
     * @param Session $checkoutSession
     * @param SkuResolver $skuResolver
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Config $getSearchspringSiteId,
        OrderItemPriceResolver $priceResolver,
        Session $checkoutSession,
        SkuResolver $skuResolver,
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
