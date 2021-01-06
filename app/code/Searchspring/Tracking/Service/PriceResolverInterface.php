<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

/**
 * Interface PriceResolverInterface
 *
 * @package Searchspring\Tracking\Service
 */
interface PriceResolverInterface
{
    /**
     * @param CartItemInterface|OrderItemInterface $product
     * @return float|null
     */
    public function getProductPrice($product): ?float;
}
