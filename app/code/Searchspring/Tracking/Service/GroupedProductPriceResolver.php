<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Searchspring\Tracking\Service\PriceResolverInterface;

/**
 * Class GroupedProductPriceResolver
 *
 * @package Searchspring\Tracking\Service
 */
class GroupedProductPriceResolver implements PriceResolverInterface
{
    /**
     * @param $product
     * @return float|null
     */
    public function getProductPrice($product): ?float
    {
        return (float)$product->getPrice();
    }
}
