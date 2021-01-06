<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

/**
 * Class DefaultSkuResolver
 *
 * @package Searchspring\Tracking\Service
 */
class DefaultSkuResolver implements SkuResolverInterface
{
    /**
     * @param CartItemInterface|OrderItemInterface $product
     * @return string|null
     */
    public function getProductSku($product): ?string
    {
        return (string)$product->getSku();
    }
}
