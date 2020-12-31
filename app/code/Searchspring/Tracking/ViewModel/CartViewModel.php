<?php
declare(strict_types=1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Quote\Model\Quote\Item as QuoteItem;
use Searchspring\Tracking\Service\Config;
use Searchspring\Tracking\Service\PriceResolver;
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
     * @var PriceResolver
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
     * @param PriceResolver $priceResolver
     * @param SkuResolver $skuResolver
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Config $getSearchspringSiteId,
        PriceResolver $priceResolver,
        SkuResolver $skuResolver,
        SerializerInterface $serializer
    ) {
        $this->getSearchspringSiteId = $getSearchspringSiteId;
        $this->priceResolver = $priceResolver;
        $this->skuResolver = $skuResolver;
        $this->serializer = $serializer;
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
            if (!is_null($quoteItem->getParentItem())) {
                continue;
            }
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
     * @param QuoteItem $quoteItem
     * @return int|null
     */
    private function getProductQuantity(QuoteItem $quoteItem): ?int
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
