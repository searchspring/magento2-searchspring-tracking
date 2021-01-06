<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

/**
 * Class DefaultPriceResolver
 *
 * @package Searchspring\Tracking\Service
 */
class DefaultPriceResolver implements
    QuoteItemPriceResolverInterface,
    OrderItemPriceResolverInterface
{
    /**
     * @param CartItemInterface|OrderItemInterface $product
     * @return float|null
     */
    public function getProductPrice($product): ?float
    {
        return (float)$product->getPrice();
    }
}
