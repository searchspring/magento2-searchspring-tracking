<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Searchspring\Tracking\Api\ConfigInterface;

/**
 * Class Config
 *
 * @package Searchspring\Tracking\Service
 */
class Config implements ConfigInterface
{
    const SEARCHSPRING_SITE_ID = 'serchspring/general/searchspring_site_id';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * @param null|int $storeId
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getSearchspringSiteId($storeId = null): ?string
    {
        $storeId = !is_null($storeId) ? $storeId : $this->storeManager->getStore()->getStoreId();
        return (string)$this->scopeConfig->getValue(
            self::SEARCHSPRING_SITE_ID,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
