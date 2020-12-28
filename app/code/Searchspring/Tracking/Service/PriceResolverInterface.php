<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

/**
 * Interface PriceResolverInterface
 *
 * @package Searchspring\Tracking\Service
 */
interface PriceResolverInterface
{
    /**
     * @param $product
     * @return array|null
     */
    public function getProductPrice($product): ?float;
}
