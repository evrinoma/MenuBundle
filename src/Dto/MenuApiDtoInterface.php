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

namespace Evrinoma\MenuBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\NameInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\AttributesInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\ChildMenuApiDtoInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\RolesInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\RootInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\RouteInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\RouteParametersInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\TagInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\UriInterface;

interface MenuApiDtoInterface extends DtoInterface, IdInterface, NameInterface, RouteInterface, AttributesInterface, RolesInterface, UriInterface, TagInterface, RouteParametersInterface, ChildMenuApiDtoInterface, RootInterface
{
    /**
     * @param DtoInterface $dto
     *
     * @return DtoInterface
     */
    public function addChildMenuApiDto(DtoInterface $dto): DtoInterface;
}
