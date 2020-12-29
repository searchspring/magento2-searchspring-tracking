<?php
declare(strict_types=1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Sales\Model\Order\Item as OrderItem;
use Searchspring\Tracking\Service\Config;
use Searchspring\Tracking\Service\PriceResolver;
use Searchspring\Tracking\Service\SkuResolver;

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
     * CheckoutViewModel constructor.
     *
     * @param Config $getSearchspringSiteId
     * @param PriceResolver $priceResolver
     * @param Session $checkoutSession
     * @param SkuResolver $skuResolver
     */
    public function __construct(
        Config $getSearchspringSiteId,
        PriceResolver $priceResolver,
        Session $checkoutSession,
        SkuResolver $skuResolver
    ) {
        $this->getSearchspringSiteId = $getSearchspringSiteId;
        $this->priceResolver = $priceResolver;
        $this->checkoutSession = $checkoutSession;
        $this->skuResolver = $skuResolver;
    }

    /**
     * @return array|null
     */
    private function getOrderItems(): ?array
    {
        return $this->checkoutSession->getLastRealOrder()->getAllItems();
    }

    /**
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getSearchspringSiteId(): ?string
    {
        return $this->getSearchspringSiteId->getSearchspringSiteId();
    }

    /**
     * @return array|null
     */
    public function getProducts(): ?array
    {
        $orderItems = $this->getOrderItems();
        foreach ($orderItems as $orderItem) {
            if (!is_null($orderItem->getParentItem())) {
                continue;
            }
            $productsPrice[]['price'] = $this->priceResolver->getProductPrice($orderItem);
            $productsSku[]['sku'] = $this->skuResolver->getProductSku($orderItem);
            $productsQty[]['qty'] = $this->getProductQuantity($orderItem);
        }
        return array_replace_recursive($productsPrice, $productsSku, $productsQty);
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
