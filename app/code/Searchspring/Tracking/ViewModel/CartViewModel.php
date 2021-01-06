<?php
declare(strict_types=1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Searchspring\Tracking\Service\Config;
use Searchspring\Tracking\Service\QuoteItemPriceResolver;
use Searchspring\Tracking\Service\SkuResolver;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class CartViewModel
 *
 * @package Searchspring\Tracking\ViewModel
 */
class CartViewModel implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $getSearchspringSiteId;

    /**
     * @var QuoteItemPriceResolver
     */
    private $priceResolver;

    /**
     * @var SkuResolver
     */
    private $skuResolver;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var array
     */
    private $productsSku = [];

    /**
     * CartViewModel constructor.
     *
     * @param Config $getSearchspringSiteId
     * @param QuoteItemPriceResolver $priceResolver
     * @param SkuResolver $skuResolver
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Config $getSearchspringSiteId,
        QuoteItemPriceResolver $priceResolver,
        SkuResolver $skuResolver,
        SerializerInterface $serializer
    ) {
        $this->getSearchspringSiteId = $getSearchspringSiteId;
        $this->priceResolver         = $priceResolver;
        $this->skuResolver           = $skuResolver;
        $this->serializer            = $serializer;
    }

    /**
     * @return string|null
     */
    public function getSearchspringSiteId(): ?string
    {
        return $this->getSearchspringSiteId->getSearchspringSiteId();
    }

    /**
     * @param array $quoteItems
     * @return string|null
     */
    public function getProducts(array $quoteItems): ?string
    {
        $this->productsSku = [];
        foreach ($quoteItems as $quoteItem) {
            $this->productsSku[] = $this->skuResolver->getProductSku($quoteItem);

            $products[] = [
                'price' => $this->priceResolver->getProductPrice($quoteItem),
                'sku'   => $this->skuResolver->getProductSku($quoteItem),
                'qty'   => $this->getProductQuantity($quoteItem)
            ];
        }
        return $this->serializer->serialize($products);
    }

    /**
     * @param CartItemInterface $quoteItem
     * @return int|null
     */
    private function getProductQuantity(CartItemInterface $quoteItem): ?int
    {
        return (int)$quoteItem->getQty();
    }

    /**
     * @return string|null
     */
    public function getProductsSku(): ?string
    {
        return $this->serializer->serialize($this->productsSku);
    }
}
