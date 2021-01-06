<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Psr\Log\LoggerInterface;

/**
 * Class PriceResolver
 *
 * @package Searchspring\Tracking\Service
 */
class PriceResolver implements PriceResolverInterface
{
    /**
     * @var array
     */
    private $quoteItemPriceResolversPool;

    /**
     * @var array
     */
    private $orderItemPriceResolversPool;

    /**
     * @var DefaultPriceResolver
     */
    private $defaultPriceResolver;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PriceResolver constructor.
     *
     * @param LoggerInterface $logger
     * @param DefaultPriceResolver $defaultPriceResolver
     * @param array $quoteItemPriceResolversPool
     * @param array $orderItemPriceResolversPool
     */
    public function __construct(
        LoggerInterface $logger,
        DefaultPriceResolver $defaultPriceResolver,
        array $quoteItemPriceResolversPool = [],
        array $orderItemPriceResolversPool = []
    ) {
        $this->logger               = $logger;
        $this->defaultPriceResolver = $defaultPriceResolver;
        $this->quoteItemPriceResolversPool   = $quoteItemPriceResolversPool;
        $this->orderItemPriceResolversPool   = $orderItemPriceResolversPool;
    }

    /**
     * @param CartItemInterface|OrderItemInterface $product
     * @return float|null
     */
    public function getProductPrice($product): ?float
    {
        if ((isset($this->quoteItemPriceResolversPool[$product->getProductType()]) &&
            $this->quoteItemPriceResolversPool[$product->getProductType()] instanceof PriceResolverInterface) ||
            (isset($this->orderItemPriceResolversPool[$product->getProductType()]) &&
            $this->orderItemPriceResolversPool[$product->getProductType()] instanceof PriceResolverInterface)) {
            if ($product instanceof CartItemInterface) {
                return (float)$this->quoteItemPriceResolversPool[$product->getProductType()]->getProductPrice($product);
            }
            if ($product instanceof OrderItemInterface) {
                return (float)$this->orderItemPriceResolversPool[$product->getProductType()]->getProductPrice($product);
            }
        } elseif (!($this->priceResolversPool[$product->getProductType()] instanceof PriceResolverInterface)) {
            $this->logger->warning(get_class($this->priceResolversPool[$product->getProductType()]) . ' must implement ' . PriceResolverInterface::class);
        }

        return (float)$this->defaultPriceResolver->getProductPrice($product);
    }
}
