<?php
declare(strict_types=1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Searchspring\Tracking\Service\SearchspringSiteId;
use Searchspring\Tracking\Service\PriceResolver;

/**
 * Class CartViewModel
 *
 * @package Searchspring\Tracking\ViewModel
 */
class CartViewModel implements ArgumentInterface
{
    /**
     * @var SearchspringSiteId
     */
    private $getSearchspringSiteId;

    /**
     * @var PriceResolver
     */
    private $priceResolver;

    /**
     * CartViewModel constructor.
     *
     * @param SearchspringSiteId $getSearchspringSiteId
     * @param PriceResolver $priceResolver
     */
    public function __construct(
        SearchspringSiteId $getSearchspringSiteId,
        PriceResolver $priceResolver
    ) {
        $this->getSearchspringSiteId = $getSearchspringSiteId;
        $this->priceResolver = $priceResolver;
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
        $productsPrice = $this->priceResolver->getProductPrice($quoteItems);
        $productsSku = $this->getProductSkuByType($quoteItems);
        $productsQty = $this->getProductQuantity($quoteItems);
        return array_replace_recursive($productsPrice, $productsSku, $productsQty);
    }

    /**
     * @param $quoteItems
     * @return array|null
     */
    private function getProductSkuByType($quoteItems): ?array
    {
        $productTypes = [
            PriceResolver::TYPE_BUNDLE,
            PriceResolver::TYPE_CONFIGURABLE
        ];
        foreach ($quoteItems as $quoteItem) {
            if ($quoteItem->getProductType() === 'grouped') {
                $productsSku[]['sku'] = $quoteItem->getOptionsByCode('product_type')['product_type']->getProduct()->getSku();
            } elseif ($quoteItem->getProductType() === 'simple') {
                $productsSku[]['sku'] = $quoteItem->getSku();
            } elseif (in_array($quoteItem->getProductType(), $productTypes)) {
                $productsSku[]['sku'] = $quoteItem->getOptionsByCode('product_type')['info_buyRequest']->getItem()->getData()['product']->getData('sku');
            }
        }
        return $productsSku;
    }

    /**
     * @param array $quoteItems
     * @return array|null
     */
    private function getProductQuantity(array $quoteItems): ?array
    {
        foreach ($quoteItems as $quoteItem) {
            $productsQty[]['qty'] = (int)$quoteItem->getQty();
        }
        return $productsQty;
    }
}
