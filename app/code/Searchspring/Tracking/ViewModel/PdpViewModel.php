<?php
declare(strict_types = 1);

namespace Searchspring\Tracking\ViewModel;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Searchspring\Tracking\Service\SearchspringSiteId;

/**
 * Class PdpViewModel
 *
 * @package Searchspring\Tracking\ViewModel
 */
class PdpViewModel implements ArgumentInterface
{
    /**
     * @var SearchspringSiteId
     */
    private $getSearchspringSiteId;

    /**
     * PdpViewModel constructor.
     *
     * @param SearchspringSiteId $getSearchspringSiteId
     */
    public function __construct(
        SearchspringSiteId $getSearchspringSiteId
    ) {
        $this->getSearchspringSiteId = $getSearchspringSiteId;
    }

    /**
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getSearchspringSiteId(): ?string
    {
        return (string)$this->getSearchspringSiteId->getSearchspringSiteId();
    }
}
