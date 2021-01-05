<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Model\Quote\Item as QuoteItem;
use Magento\Sales\Model\Order\Item as OrderItem;
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
    private $priceResolversPool;

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
     * @param array $priceResolversPool
     */
    public function __construct(
        LoggerInterface $logger,
        DefaultPriceResolver $defaultPriceResolver,
        array $priceResolversPool = []
    ) {
        $this->logger               = $logger;
        $this->defaultPriceResolver = $defaultPriceResolver;
        $this->priceResolversPool   = $priceResolversPool;
    }

    /**
     * @param OrderItem|QuoteItem $product
     * @return float|null
     */
    public function getProductPrice($product): ?float
    {
        if (isset($this->priceResolversPool[$product->getProductType()]) &&
            $this->priceResolversPool[$product->getProductType()] instanceof PriceResolverInterface) {
            return (float)$this->priceResolversPool[$product->getProductType()]->getProductPrice($product);
        } elseif (!($this->priceResolversPool[$product->getProductType()] instanceof PriceResolverInterface)) {
            $this->logger->warning(get_class($this->priceResolversPool[$product->getProductType()]) . ' must implement ' . PriceResolverInterface::class);
        }

        return (float)$this->defaultPriceResolver->getProductPrice($product);
    }
}
