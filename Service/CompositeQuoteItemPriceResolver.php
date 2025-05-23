<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Quote\Api\Data\CartItemInterface;
use Psr\Log\LoggerInterface;

/**
 * Class QuoteItemPriceResolver
 *
 * In di.xml we can configure quoteItemPriceResolversPool.This class can resolve way by which we will get product price for quote item (cart page).
 *
 * @package Searchspring\Tracking\Service
 */
class CompositeQuoteItemPriceResolver implements QuoteItemPriceResolverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var QuoteItemPriceResolverInterface
     */
    private $defaultPriceResolver;

    /**
     * @var array
     */
    private $quoteItemPriceResolversPool;

    /**
     * QuoteItemPriceResolver constructor.
     *
     * @param LoggerInterface $logger
     * @param QuoteItemPriceResolverInterface $defaultPriceResolver
     * @param array $quoteItemPriceResolversPool
     */
    public function __construct(
        LoggerInterface $logger,
        QuoteItemPriceResolverInterface $defaultPriceResolver,
        array $quoteItemPriceResolversPool = []
    ) {
        $this->logger = $logger;
        $this->defaultPriceResolver = $defaultPriceResolver;
        $this->quoteItemPriceResolversPool = $quoteItemPriceResolversPool;
    }

    /**
     * @param CartItemInterface $product
     * @return float|null
     */
    public function getProductPrice(CartItemInterface $product): ?float
    {
        if ((isset($this->quoteItemPriceResolversPool[$product->getProductType()]) &&
            $this->quoteItemPriceResolversPool[$product->getProductType()] instanceof QuoteItemPriceResolverInterface)) {
            return (float)$this->quoteItemPriceResolversPool[$product->getProductType()]->getProductPrice($product);
        } elseif (isset($this->quoteItemPriceResolversPool[$product->getProductType()]) && 
                  !($this->quoteItemPriceResolversPool[$product->getProductType()] instanceof QuoteItemPriceResolverInterface)) {
            $this->logger->warning(get_class($this->quoteItemPriceResolversPool[$product->getProductType()]) . ' must implement ' . QuoteItemPriceResolverInterface::class);
        }

        return (float)$this->defaultPriceResolver->getProductPrice($product);
    }
}
