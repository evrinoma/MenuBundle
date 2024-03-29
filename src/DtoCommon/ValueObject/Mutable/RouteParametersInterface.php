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

namespace Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface RouteParametersInterface
{
    /**
     * @param array $routeParameters
     *
     * @return DtoInterface
     */
    public function setRouteParameters(array $routeParameters): DtoInterface;
}
