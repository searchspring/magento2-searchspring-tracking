<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

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
        $qty = !is_null($product->getQty()) ? (int)$product->getQty() : (int)$product->getQtyOrdered();
        return (float)$product->getProduct()->getFinalPrice($qty);
    }
}
