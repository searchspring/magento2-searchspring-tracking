<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;

/**
 * Interface QuoteItemPriceResolverInterface
 *
 * @package Searchspring\Tracking\Service
 */
interface QuoteItemPriceResolverInterface
{
    /**
     * @param CartItemInterface $product
     * @return float|null
     */
    public function getProductPrice(CartItemInterface $product): ?float;
}
