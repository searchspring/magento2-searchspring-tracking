<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Sales\Api\Data\OrderItemInterface;
use Psr\Log\LoggerInterface;

/**
 * Class OrderItemPriceResolver
 *
 * In di.xml we can configure orderItemPriceResolversPool.This class can resolve way by which we will get product price for order item (checkout success page).
 *
 * @package Searchspring\Tracking\Service
 */
class CompositeOrderItemPriceResolver implements OrderItemPriceResolverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var OrderItemPriceResolverInterface
     */
    private $defaultPriceResolver;

    /**
     * @var array
     */
    private $orderItemPriceResolversPool;

    /**
     * OrderItemPriceResolver constructor.
     *
     * @param LoggerInterface $logger
     * @param OrderItemPriceResolverInterface $defaultPriceResolver
     * @param array $orderItemPriceResolversPool
     */
    public function __construct(
        LoggerInterface $logger,
        OrderItemPriceResolverInterface $defaultPriceResolver,
        array $orderItemPriceResolversPool = []
    ) {
        $this->logger = $logger;
        $this->defaultPriceResolver = $defaultPriceResolver;
        $this->orderItemPriceResolversPool = $orderItemPriceResolversPool;
    }

    /**
     * @param OrderItemInterface $product
     * @return float|null
     */
    public function getProductPrice(OrderItemInterface $product): ?float
    {
        if ((isset($this->orderItemPriceResolversPool[$product->getProductType()]) &&
                $this->orderItemPriceResolversPool[$product->getProductType()] instanceof OrderItemPriceResolverInterface)) {
            return (float)$this->orderItemPriceResolversPool[$product->getProductType()]->getProductPrice($product);
        } elseif (isset($this->orderItemPriceResolversPool[$product->getProductType()]) && 
                  !($this->orderItemPriceResolversPool[$product->getProductType()] instanceof OrderItemPriceResolverInterface)) {
            $this->logger->warning(get_class($this->orderItemPriceResolversPool[$product->getProductType()]) . ' must implement ' . OrderItemPriceResolverInterface::class);
        }

        return (float)$this->defaultPriceResolver->getProductPrice($product);
    }
}
