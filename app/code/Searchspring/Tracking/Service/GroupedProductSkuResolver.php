<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote\Item as QuoteItem;
use Magento\Sales\Model\Order\Item as OrderItem;

/**
 * Class GroupedProductSkuResolver
 *
 * @package Searchspring\Tracking\Service
 */
class GroupedProductSkuResolver implements SkuResolverInterface
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * @param OrderItem|QuoteItem $product
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getProductSku($product): ?string
    {
        if ($product instanceof CartItemInterface) {
            return (string)$product->getOptionByCode('product_type')
                                   ->getProduct()
                                   ->getSku();
        }
        if ($product instanceof OrderItemInterface) {
            return (string)$this->productRepository
                                ->getById(
                                    (int)$product
                                    ->getProductOptions()['super_product_config']['product_id']
                                )
                                ->getSku();
        }
    }
}
