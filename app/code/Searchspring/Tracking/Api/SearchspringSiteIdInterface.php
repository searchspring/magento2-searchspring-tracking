<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Api;

/**
 * Interface SearchspringSiteIdInterface
 *
 * @package Searchspring\Tracking\Api
 */
interface SearchspringSiteIdInterface
{
    /**
     * @return string|null
     */
    public function getSearchspringSiteId(): ?string;
}
