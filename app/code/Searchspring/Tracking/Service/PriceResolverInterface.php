<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Model\Quote\Item as QuoteItem;
use Magento\Sales\Model\Order\Item as OrderItem;

/**
 * Interface PriceResolverInterface
 *
 * @package Searchspring\Tracking\Service
 */
interface PriceResolverInterface
{
    /**
     * @param OrderItem|QuoteItem $product
     * @return float|null
     */
    public function getProductPrice($product): ?float;
}
