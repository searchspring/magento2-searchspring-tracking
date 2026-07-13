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

use Magento\Sales\Api\Data\OrderItemInterface;

class CompositeOrderLineItemResolver implements OrderLineItemResolverInterface
{
    /**
     * @var OrderLineItemResolverInterface[]
     */
    private $orderLineItemResolversPool;

    /**
     * @var OrderLineItemResolverInterface
     */
    private $defaultResolver;

    /**
     * @param OrderLineItemResolverInterface[] $orderLineItemResolversPool
     * @param OrderLineItemResolverInterface $defaultResolver
     */
    public function __construct(
        array $orderLineItemResolversPool,
        OrderLineItemResolverInterface $defaultResolver
    ) {
        $this->orderLineItemResolversPool = $orderLineItemResolversPool;
        $this->defaultResolver = $defaultResolver;
    }

    /**
     * @param OrderItemInterface $orderItem
     * @return array<string, mixed>|null
     */
    public function resolve(OrderItemInterface $orderItem): ?array
    {
        $productType = (string)$orderItem->getProductType();

        $resolver = $this->orderLineItemResolversPool[$productType] ?? $this->defaultResolver;

        return $resolver->resolve($orderItem);
    }
}
