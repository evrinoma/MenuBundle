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

namespace Evrinoma\MenuBundle\Manager;

use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuCannotBeRemovedException;
use Evrinoma\MenuBundle\Exception\MenuInvalidException;
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;

interface CommandManagerInterface
{
    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return MenuInterface
     *
     * @throws MenuInvalidException
     */
    public function post(MenuApiDtoInterface $dto): MenuInterface;

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return MenuInterface
     *
     * @throws MenuInvalidException
     * @throws MenuNotFoundException
     */
    public function put(MenuApiDtoInterface $dto): MenuInterface;

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @throws MenuCannotBeRemovedException
     * @throws MenuNotFoundException
     */
    public function delete(MenuApiDtoInterface $dto): void;
}
