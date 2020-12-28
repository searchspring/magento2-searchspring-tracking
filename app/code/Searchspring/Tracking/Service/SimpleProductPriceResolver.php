<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Searchspring\Tracking\Service\PriceResolverInterface;

/**
 * Class SimpleProductPriceResolver
 *
 * @package Searchspring\Tracking\Service
 */
class SimpleProductPriceResolver implements PriceResolverInterface
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
