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

namespace Evrinoma\MenuBundle\Mediator;

use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuCannotBeCreatedException;
use Evrinoma\MenuBundle\Exception\MenuCannotBeRemovedException;
use Evrinoma\MenuBundle\Exception\MenuCannotBeSavedException;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;

interface CommandMediatorInterface
{
    /**
     * @param MenuApiDtoInterface $dto
     * @param MenuInterface       $entity
     *
     * @return MenuInterface
     *
     * @throws MenuCannotBeSavedException
     */
    public function onUpdate(MenuApiDtoInterface $dto, MenuInterface $entity): MenuInterface;

    /**
     * @param MenuApiDtoInterface $dto
     * @param MenuInterface       $entity
     *
     * @throws MenuCannotBeRemovedException
     */
    public function onDelete(MenuApiDtoInterface $dto, MenuInterface $entity): void;

    /**
     * @param MenuApiDtoInterface $dto
     * @param MenuInterface       $entity
     *
     * @return MenuInterface
     *
     * @throws MenuCannotBeSavedException
     * @throws MenuCannotBeCreatedException
     */
    public function onCreate(MenuApiDtoInterface $dto, MenuInterface $entity): MenuInterface;
}
