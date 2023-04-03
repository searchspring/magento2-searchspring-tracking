<?php

declare(strict_types=1);

namespace SearchSpring\Tracking\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session;

class Tracking implements SectionSourceInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * Tracking constructor.
     * @param Session $session
     */
    public function __construct(
        Session $session
    ) {
        $this->session = $session;
    }

    /**
     * @return array|void
     */
    public function getSectionData() : array
    {
        return [
            'shopper_id' => $this->session->getCustomerId()
        ];
    }
}
