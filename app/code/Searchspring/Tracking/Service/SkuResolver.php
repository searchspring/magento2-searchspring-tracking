<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Model\Quote\Item as QuoteItem;
use Magento\Sales\Model\Order\Item as OrderItem;
use Psr\Log\LoggerInterface;

/**
 * Class SkuResolver
 *
 * @package Searchspring\Tracking\Service
 */
class SkuResolver
{
    const TYPE_SIMPLE = 'simple';
    const TYPE_CONFIGURABLE = 'configurable';
    const TYPE_BUNDLE = 'bundle';
    const TYPE_GROUPED = 'grouped';

    /**
     * @var array
     */
    private $skuResolversPool;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SkuResolver constructor.
     *
     * @param LoggerInterface $logger
     * @param array $skuResolversPool
     */
    public function __construct(
        LoggerInterface $logger,
        $skuResolversPool = array()
    ) {
        $this->skuResolversPool = $skuResolversPool;
        $this->logger = $logger;
    }

    /**
     * @param OrderItem|QuoteItem $product
     * @return string|null
     */
    public function getProductSku($product): ?string
    {
        if (!$this->skuResolversPool[$product->getProductType()] instanceof SkuResolverInterface) {
            $e = new \Exception();
            $this->logger->warning($e);
        }
        if (isset($this->skuResolversPool[$product->getProductType()])) {
            return (string)$this->skuResolversPool[$product->getProductType()]->getProductSku($product);
        }
        return (string)$product->getSku();
    }
}
