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

namespace Evrinoma\MenuBundle\Factory;

use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;

interface MenuFactoryInterface
{
    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return MenuInterface
     */
    public function create(MenuApiDtoInterface $dto): MenuInterface;
}
