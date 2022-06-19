<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable;

trait RouteTrait
{
    private string $route = '';

    /**
     * @return bool
     */
    public function hasRoute(): bool
    {
        return '' !== $this->route;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }
}
