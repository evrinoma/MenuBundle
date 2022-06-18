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

interface MenuApiDtoInterface extends DtoInterface, IdInterface
{
    public const TAG = 'tag';

    /**
     * @return string
     */
    public function getTag(): string;

    /**
     * @return bool
     */
    public function hasTag(): bool;
}
