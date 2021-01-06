<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Quote\Model\Quote\Item as QuoteItem;
use Magento\Sales\Model\Order\Item as OrderItem;

/**
 * Class ProductPriceResolver
 *
 * @package Searchspring\Tracking\Service
 */
class ProductPriceResolver implements PriceResolverInterface
{
    /**
     * @param OrderItem|QuoteItem $product
     * @return float|null
     */
    public function getProductPrice($product): ?float
    {
        if ($product instanceof CartItemInterface) {
            return (float)$product->getCalculationPrice();
        }
        if ($product instanceof OrderItemInterface) {
            return (float)$product->getPrice();
        }
    }
}
