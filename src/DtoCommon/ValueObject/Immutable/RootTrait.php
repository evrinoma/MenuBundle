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

trait RootTrait
{
    private ?bool  $root = null;

    /**
     * @return bool
     */
    public function hasRoot(): bool
    {
        return null !== $this->root;
    }

    /**
     * @return bool
     */
    public function isRoot(): bool
    {
        return $this->root;
    }
}
