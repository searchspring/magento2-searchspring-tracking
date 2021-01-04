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
class PriceResolver
{
    const TYPE_SIMPLE = 'simple';
    const TYPE_CONFIGURABLE = 'configurable';
    const TYPE_BUNDLE = 'bundle';
    const TYPE_GROUPED = 'grouped';

    /**
     * @var array
     */
    private $priceResolversPool;

    /**
     * PriceResolver constructor.
     *
     * @param LoggerInterface $logger
     * @param array $priceResolversPool
     */
    public function __construct(
        LoggerInterface $logger,
        $priceResolversPool = array()
    ) {
        $this->priceResolversPool = $priceResolversPool;
        $this->logger = $logger;
    }

    /**
     * @param OrderItem|QuoteItem $product
     * @return float|null
     */
    public function getProductPrice($product): ?float
    {
        if (!$this->priceResolversPool[$product->getProductType()] instanceof PriceResolverInterface) {
            $e = new \Exception();
            $this->logger->warning($e);
        }
        if (isset($this->priceResolversPool[$product->getProductType()])) {
            return (float)$this->priceResolversPool[$product->getProductType()]->getProductPrice($product);
        }
        return (float)$product->getProduct()->getFinalPrice();

    }
}
