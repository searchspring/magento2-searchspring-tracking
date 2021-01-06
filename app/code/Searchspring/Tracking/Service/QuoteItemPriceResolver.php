<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;

/**
 * Class QuoteItemPriceResolver
 *
 * @package Searchspring\Tracking\Service
 */
class QuoteItemPriceResolver implements PriceResolverInterface
{
    /**
     * @param CartItemInterface $product
     * @return float|null
     */
    public function getProductPrice($product): ?float
    {
        return (float)$product->getCalculationPrice();
    }
}
