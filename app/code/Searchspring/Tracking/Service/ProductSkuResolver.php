<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Model\Quote\Item as QuoteItem;
use Magento\Sales\Model\Order\Item as OrderItem;

/**
 * Class ProductSkuResolver
 *
 * @package Searchspring\Tracking\Service
 */
class ProductSkuResolver implements SkuResolverInterface
{
    /**
     * @param OrderItem|QuoteItem $product
     * @return string|null
     */
    public function getProductSku($product): ?string
    {
        return (string)$product->getSku();
    }
}
