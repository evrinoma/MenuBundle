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

namespace Evrinoma\MenuBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait RootTrait
{
    /**
     * @return DtoInterface
     */
    public function setRoot(): DtoInterface
    {
        return parent::setRoot();
    }

    /**
     * @return DtoInterface
     */
    public function resetRoot(): DtoInterface
    {
        return parent::resetRoot();
    }
}
