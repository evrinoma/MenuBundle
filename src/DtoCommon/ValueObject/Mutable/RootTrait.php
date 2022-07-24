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
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\RootTrait as RootImmutableTrait;

trait RootTrait
{
    use RootImmutableTrait;

    /**
     * @return DtoInterface
     */
    protected function setRoot(): DtoInterface
    {
        $this->root = true;

        return $this;
    }

    /**
     * @return DtoInterface
     */
    protected function resetRoot(): DtoInterface
    {
        $this->root = false;

        return $this;
    }
}
