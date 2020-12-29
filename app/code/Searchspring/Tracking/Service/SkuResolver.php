<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Model\Quote\Item as QuoteItem;
use Magento\Sales\Model\Order\Item as OrderItem;

/**
 * Class SkuResolver
 *
 * @package Searchspring\Tracking\Service
 */
class SkuResolver
{
    const TYPE_SIMPLE       = 'simple';
    const TYPE_CONFIGURABLE = 'configurable';
    const TYPE_BUNDLE       = 'bundle';
    const TYPE_GROUPED      = 'grouped';

    /**
     * @var array
     */
    private $skuResolversPool;

    /**
     * SkuResolver constructor.
     *
     * @param array $skuResolversPool
     */
    public function __construct(
        $skuResolversPool = []
    ) {
        $this->skuResolversPool = $skuResolversPool;
    }

    /**
     * @param OrderItem|QuoteItem $product
     * @return string|null
     */
    public function getProductSku($product): ?string
    {
        if (isset($this->skuResolversPool[$product->getProductType()]) &&
                $this->skuResolversPool[$product->getProductType()] instanceof SkuResolverInterface) {
            return (string)$this->skuResolversPool[$product->getProductType()]->getProductSku($product);
        }

        return (string)$this->defaultResolver($product);
    }

    /**
     * @param OrderItem|QuoteItem $product
     * @return string|null
     */
    public function defaultResolver($product): ?string
    {
        return (string)$product->getSku();
    }
}
