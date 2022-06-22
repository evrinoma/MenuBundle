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

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface ChildMenuApiDtoInterface
{
    public const CHILD_MENU = 'child_menu';

    /**
     * @return DtoInterface[]
     */
    public function getChildMenuApiDto(): array;

    /**
     * @return bool
     */
    public function hasChildMenuApiDto(): bool;
}
