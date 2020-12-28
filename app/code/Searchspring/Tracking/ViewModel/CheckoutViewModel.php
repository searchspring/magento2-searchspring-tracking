<?php
declare(strict_types=1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Catalog\Model\ProductRepository;
use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Searchspring\Tracking\Service\SearchspringSiteId;
use Searchspring\Tracking\Service\PriceResolver;

class CheckoutViewModel implements ArgumentInterface
{
    /**
     * @var SearchspringSiteId
     */
    private $getSearchspringSiteId;

    /**
     * @var PriceResolver
     */
    private $priceResolver;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        SearchspringSiteId $getSearchspringSiteId,
        PriceResolver $priceResolver,
        Session $checkoutSession,
        ProductRepository $productRepository
    ) {
        $this->getSearchspringSiteId = $getSearchspringSiteId;
        $this->priceResolver = $priceResolver;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
    }

    /**
     * @return array|null
     */
    private function getOrderItems(): ?array
    {
        return $this->checkoutSession->getLastRealOrder()->getAllVisibleItems();
    }

    /**
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getSearchspringSiteId(): ?string
    {
        return $this->getSearchspringSiteId->getSearchspringSiteId();
    }

    /**
     * @return array|null
     * @throws NoSuchEntityException
     */
    public function getProducts(): ?array
    {
        $orderItems = $this->getOrderItems();
        $productsPrice = $this->priceResolver->getProductPrice($orderItems);
        $productsSku = $this->getProductSkuByType($orderItems);
        $productsQty = $this->getProductQuantity($orderItems);
        return array_replace_recursive($productsPrice, $productsSku, $productsQty);
    }

    /**
     * @param $orderItems
     * @return array|null
     * @throws NoSuchEntityException
     */
    private function getProductSkuByType($orderItems): ?array
    {
        $productTypes = [
            PriceResolver::TYPE_BUNDLE,
            PriceResolver::TYPE_CONFIGURABLE
        ];
        foreach ($orderItems as $orderItem) {
            if ($orderItem->getProductType() === 'simple') {
                $productsSku[]['sku'] = $orderItem->getSku();
            } elseif ($orderItem->getProductType() === 'grouped') {
                $productsSku[]['sku'] = $this->productRepository->getById((int)$orderItem->getProductOptions()['super_product_config']['product_id'])->getSku();
            } elseif (in_array($orderItem->getProductType(), $productTypes)) {
                $productsSku[]['sku'] = $this->productRepository->getById($orderItem->getProductId())->getSku();
            }
        }
        return $productsSku;
    }

    /**
     * @param array $orderItems
     * @return array|null
     */
    private function getProductQuantity(array $orderItems): ?array
    {
        $skipedProducts = [
            'virtual', 'downloadable'
        ];
        foreach ($orderItems as $orderItem) {
            if (in_array($orderItem->getProductType(), $skipedProducts)) {
                continue;
            }
            $productsQty[]['qty'] = (int)$orderItem->getQtyOrdered();
        }
        return $productsQty;
    }
}
