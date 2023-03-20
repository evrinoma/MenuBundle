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

use Evrinoma\DtoCommon\ValueObject\Preserve\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\NameTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\AttributesTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Preserve\ChildMenuApiDtoTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Preserve\RolesTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Preserve\RootTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Preserve\RouteParametersTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Preserve\RouteTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Preserve\TagTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Preserve\UriTrait;

trait MenuApiDtoTrait
{
    use AttributesTrait;
    use ChildMenuApiDtoTrait;
    use IdTrait;
    use NameTrait;
    use RolesTrait;
    use RootTrait;
    use RouteParametersTrait;
    use RouteTrait;
    use TagTrait;
    use UriTrait;
}
