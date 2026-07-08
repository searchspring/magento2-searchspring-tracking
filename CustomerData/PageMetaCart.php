<?php

declare(strict_types=1);

namespace Searchspring\Tracking\CustomerData;

use Searchspring\Tracking\Service\CartMetaProvider;
use Magento\Customer\CustomerData\SectionSourceInterface;

class PageMetaCart implements SectionSourceInterface
{
    /**
     * @var CartMetaProvider
     */
    private $cartMetaProvider;

    /**
     * @param CartMetaProvider $cartMetaProvider
     */
    public function __construct(
        CartMetaProvider $cartMetaProvider
    )
    {
        $this->cartMetaProvider = $cartMetaProvider;
    }

    /**
     * @return array
     */
    public function getSectionData(): array
    {
        return $this->cartMetaProvider->get();
    }
}
