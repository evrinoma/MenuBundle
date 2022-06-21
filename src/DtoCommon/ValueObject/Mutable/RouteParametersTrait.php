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
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\RouteParametersTrait as RouteParametersImmutableTrait;

trait RouteParametersTrait
{
    use RouteParametersImmutableTrait;

    /**
     * @param array $routeParameters
     *
     * @return DtoInterface
     */
    protected function setRouteParameters(array $routeParameters): DtoInterface
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }
}
