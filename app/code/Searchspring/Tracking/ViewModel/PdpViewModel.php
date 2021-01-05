<?php
declare(strict_types = 1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Searchspring\Tracking\Service\Config;

/**
 * Class PdpViewModel
 *
 * @package Searchspring\Tracking\ViewModel
 */
class PdpViewModel implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $getSearchspringSiteId;

    /**
     * PdpViewModel constructor.
     *
     * @param Config $getSearchspringSiteId
     */
    public function __construct(
        Config $getSearchspringSiteId
    ) {
        $this->getSearchspringSiteId = $getSearchspringSiteId;
    }

    /**
     * @return string|null
     */
    public function getSearchspringSiteId(): ?string
    {
        return (string)$this->getSearchspringSiteId->getSearchspringSiteId();
    }
}
