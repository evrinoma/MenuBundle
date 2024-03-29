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

namespace Evrinoma\MenuBundle\Dto\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\AttributesInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\RolesInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\ChildMenuApiDtoInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\RootInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\RouteInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\RouteParametersInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\TagInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\UriInterface;

interface MenuApiDtoInterface extends DtoInterface, IdInterface, NameInterface, RouteInterface, AttributesInterface, RolesInterface, UriInterface, TagInterface, RouteParametersInterface, ChildMenuApiDtoInterface, RootInterface
{
}
