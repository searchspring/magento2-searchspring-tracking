<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;

/**
 * Class QuoteItemPrice
 *
 * This class gets price for quote item (cart page)
 *
 * @package Searchspring\Tracking\Service
 */
class QuoteItemPriceResolver implements QuoteItemPriceResolverInterface
{
    /**
     * @param CartItemInterface $product
     * @return float|null
     */
    public function getProductPrice(CartItemInterface $product): ?float
    {
        return (float)$product->getCalculationPrice();
    }
}
