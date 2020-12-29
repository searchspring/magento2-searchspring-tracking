<?php
declare(strict_types=1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Quote\Model\Quote\Item as QuoteItem;
use Searchspring\Tracking\Service\Config;
use Searchspring\Tracking\Service\PriceResolver;
use Searchspring\Tracking\Service\SkuResolver;

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
     * @var array
     */
    private $productsSku = [];

    /**
     * CartViewModel constructor.
     *
     * @param Config $getSearchspringSiteId
     * @param PriceResolver $priceResolver
     * @param SkuResolver $skuResolver
     */
    public function __construct(
        Config $getSearchspringSiteId,
        PriceResolver $priceResolver,
        SkuResolver $skuResolver
    ) {
        $this->getSearchspringSiteId = $getSearchspringSiteId;
        $this->priceResolver = $priceResolver;
        $this->skuResolver = $skuResolver;
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
     * @param array $quoteItems
     * @return array|null
     */
    public function getProducts(array $quoteItems): ?array
    {
        $this->productsSku = [];
        foreach ($quoteItems as $quoteItem) {
            if (!is_null($quoteItem->getParentItem())) {
                continue;
            }
            $productsPrice[]['price'] = $this->priceResolver->getProductPrice($quoteItem);
            $productsSku[]['sku'] = $this->skuResolver->getProductSku($quoteItem);
            $productsQty[]['qty'] = $this->getProductQuantity($quoteItem);
            $this->productsSku[] = $this->skuResolver->getProductSku($quoteItem);
        }
        return array_replace_recursive($productsPrice, $productsSku, $productsQty);
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
     * @return array
     */
    public function getProductsSku(): array
    {
        return $this->productsSku;
    }
}
