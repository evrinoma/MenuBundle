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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    public function onUpdate(DtoInterface $dto, $entity): MenuInterface
    {
        /* @var $dto MenuApiDtoInterface */
        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {

    }

    public function onCreate(DtoInterface $dto, $entity): MenuInterface
    {
        /* @var $dto MenuApiDtoInterface */

        return $entity;
    }
}
