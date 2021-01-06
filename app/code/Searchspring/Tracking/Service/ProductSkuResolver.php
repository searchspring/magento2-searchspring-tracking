<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

/**
 * Class ProductSkuResolver
 *
 * @package Searchspring\Tracking\Service
 */
class ProductSkuResolver implements SkuResolverInterface
{
    /**
     * @param CartItemInterface|OrderItemInterface $product
     * @return string|null
     */
    public function getProductSku($product): ?string
    {
        return (string)$product->getProduct()->getData('sku');
    }
}
