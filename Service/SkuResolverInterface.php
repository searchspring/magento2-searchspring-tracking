<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

/**
 * Interface SkuResolverInterface
 *
 * @package Searchspring\Tracking\Service
 */
interface SkuResolverInterface
{
    /**
     * @param CartItemInterface|OrderItemInterface $product
     * @return string|null
     */
    public function getProductSku($product): ?string;
}
