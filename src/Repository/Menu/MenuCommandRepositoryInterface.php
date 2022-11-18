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

namespace Evrinoma\MenuBundle\Repository\Menu;

use Evrinoma\MenuBundle\Exception\MenuCannotBeRemovedException;
use Evrinoma\MenuBundle\Exception\MenuCannotBeSavedException;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;

interface MenuCommandRepositoryInterface
{
    /**
     * @param MenuInterface $menu
     *
     * @return bool
     *
     * @throws MenuCannotBeSavedException
     */
    public function save(MenuInterface $menu): bool;

    /**
     * @param MenuInterface $menu
     *
     * @return bool
     *
     * @throws MenuCannotBeRemovedException
     */
    public function remove(MenuInterface $menu): bool;
}
