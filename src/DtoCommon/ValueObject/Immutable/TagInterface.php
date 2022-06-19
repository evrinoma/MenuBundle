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

interface TagInterface
{
    public const TAG = 'tag';

    /**
     * @return bool
     */
    public function hasTag(): bool;

    /**
     * @return string
     */
    public function getTag(): string;
}
