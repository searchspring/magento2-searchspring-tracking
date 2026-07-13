<?php

/**
 * Copyright (C) 2025 Searchspring <https://searchspring.com>
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3 of the License.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

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
 * This class gets searchspring site id which entered from admin panel
 *
 * @package Searchspring\Tracking\Service
 */
class Config implements ConfigInterface
{
    const SEARCHSPRING_SITE_ID = 'serchspring/general/searchspring_site_id';
    const SEARCHSPRING_TRACKING_SCRIPT_SRC = 'serchspring/tracking/script_src';
    const SEARCHSPRING_DEBUG_LOG_ENABLED = 'serchspring/tracking/enable_debug_log';

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
        ScopeConfigInterface  $scopeConfig,
        StoreManagerInterface $storeManager
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * @param int|null $storeId
     * @return string|null
     */
    public function getSearchspringSiteId(?int $storeId = null): ?string
    {
        return (string)$this->scopeConfig->getValue(
            self::SEARCHSPRING_SITE_ID,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param int|null $storeId
     * @return string|null
     */
    public function getSiteId(?int $storeId = null): ?string
    {
        return $this->getSearchspringSiteId($storeId);
    }

    /**
     * @return string
     */
    public function getTrackingScriptSrc(?int $storeId = null): string
    {
        $url = (string)$this->scopeConfig->getValue(
            self::SEARCHSPRING_TRACKING_SCRIPT_SRC,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        if (empty($url)) {
            $url = 'https://cdn.athoscommerce.net/analytics/beacon.js';
        }
        return $url;
    }

    /**
     * @param int|null $storeId
     * @return bool
     */
    public function isDebugLogEnabled(?int $storeId = null): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::SEARCHSPRING_DEBUG_LOG_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @return bool
     */
    public function shouldRender(): bool
    {
        return $this->getSiteId() && $this->getTrackingScriptSrc();
    }
}
