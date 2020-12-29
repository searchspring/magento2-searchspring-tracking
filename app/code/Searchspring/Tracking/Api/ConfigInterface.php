<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Api;

/**
 * Interface ConfigInterface
 *
 * @package Searchspring\Tracking\Api
 */
interface ConfigInterface
{
    /**
     * @return string|null
     */
    public function getSearchspringSiteId(): ?string;
}
