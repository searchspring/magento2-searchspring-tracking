<?php
declare(strict_types=1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Sales\Model\Order\Item as OrderItem;
use Searchspring\Tracking\Service\Config;
use Searchspring\Tracking\Service\PriceResolver;
use Searchspring\Tracking\Service\SkuResolver;
use Magento\Framework\Serialize\SerializerInterface;

class CheckoutViewModel implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $getSearchspringSiteId;

    /**
     * @var PriceResolver
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
     * @param PriceResolver $priceResolver
     * @param Session $checkoutSession
     * @param SkuResolver $skuResolver
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Config $getSearchspringSiteId,
        PriceResolver $priceResolver,
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
     * @param OrderItem $orderItem
     * @return int|null
     */
    private function getProductQuantity(OrderItem $orderItem): ?int
    {
        return (int)$orderItem->getQtyOrdered();
    }
}
