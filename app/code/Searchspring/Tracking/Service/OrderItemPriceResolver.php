<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Sales\Api\Data\OrderItemInterface;

/**
 * Class OrderItemPriceResolver
 *
 * @package Searchspring\Tracking\Service
 */
class OrderItemPriceResolver implements PriceResolverInterface
{
    /**
     * @param OrderItemInterface $product
     * @return float|null
     */
    public function getProductPrice($product): ?float
    {
        return (float)$product->getPrice();
    }
}
