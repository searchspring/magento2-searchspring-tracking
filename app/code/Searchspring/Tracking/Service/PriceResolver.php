<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

/**
 * Class PriceResolver
 *
 * @package Searchspring\Tracking\Service
 */
class PriceResolver
{
    const TYPE_SIMPLE       = 'simple';
    const TYPE_CONFIGURABLE = 'configurable';
    const TYPE_BUNDLE       = 'bundle';
    const TYPE_GROUPED      = 'grouped';

    /**
     * @var array
     */
    private $resolversPool;

    /**
     * PriceResolver constructor.
     *
     * @param array $resolversPool
     */
    public function __construct(
        $resolversPool = []
    ) {
        $this->resolversPool = $resolversPool;
    }

    /**
     * @param array $products
     * @return array|null
     */
    public function getProductPrice(array $products): ?array
    {
        foreach ($products as $product) {
            $qty = !is_null($product->getQty()) ? (int)$product->getQty() : (int)$product->getQtyOrdered();
            if (isset($this->resolversPool[$product->getProductType()]) &&
                $this->resolversPool[$product->getProductType()] instanceof PriceResolverInterface) {
                $result[]['price'] = $this->resolversPool[$product->getProductType()]->getProductPrice($product) * $qty;
            }
        }
        return $result;
    }
}
