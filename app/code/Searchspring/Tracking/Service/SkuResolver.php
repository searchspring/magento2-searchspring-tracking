<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Psr\Log\LoggerInterface;

/**
 * Class SkuResolver
 *
 * @package Searchspring\Tracking\Service
 */
class SkuResolver implements SkuResolverInterface
{
    /**
     * @var array
     */
    private $skuResolversPool;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var DefaultSkuResolver
     */
    private $defaultSkuResolver;

    /**
     * SkuResolver constructor.
     *
     * @param LoggerInterface $logger
     * @param DefaultSkuResolver $defaultSkuResolver
     * @param array $skuResolversPool
     */
    public function __construct(
        LoggerInterface $logger,
        DefaultSkuResolver $defaultSkuResolver,
        array $skuResolversPool = []
    ) {
        $this->logger             = $logger;
        $this->defaultSkuResolver = $defaultSkuResolver;
        $this->skuResolversPool   = $skuResolversPool;
    }

    /**
     * @param CartItemInterface|OrderItemInterface $product
     * @return string|null
     */
    public function getProductSku($product): ?string
    {
        if (isset($this->skuResolversPool[$product->getProductType()]) &&
            $this->skuResolversPool[$product->getProductType()] instanceof SkuResolverInterface) {
            return (string)$this->skuResolversPool[$product->getProductType()]->getProductSku($product);
        } elseif (!($this->skuResolversPool[$product->getProductType()] instanceof SkuResolverInterface)) {
            $this->logger->warning(get_class($this->skuResolversPool[$product->getProductType()]) . ' must implement ' . SkuResolverInterface::class);
        }

        return (string)$this->defaultSkuResolver->getProductSku($product);
    }
}
