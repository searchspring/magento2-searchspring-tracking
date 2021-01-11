<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Sales\Api\Data\OrderItemInterface;

/**
 * Class OrderItemPrice
 *
 * @package Searchspring\Tracking\Service
 */
class OrderItemPriceResolver implements OrderItemPriceResolverInterface
{
    /**
     * @param OrderItemInterface $product
     * @return float|null
     */
    public function getProductPrice(OrderItemInterface $product): ?float
    {
        return (float)$product->getPrice();
    }
}
