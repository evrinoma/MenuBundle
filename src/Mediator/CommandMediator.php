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
use Evrinoma\MenuBundle\Exception\MenuCannotBeCreatedException;
use Evrinoma\MenuBundle\Exception\MenuCannotBeSavedException;
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;
use Evrinoma\MenuBundle\Repository\MenuQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    private MenuQueryRepositoryInterface $repository;

    public function __construct(MenuQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function onUpdate(DtoInterface $dto, $entity): MenuInterface
    {
        /* @var $entity MenuInterface */
        /* @var $dto MenuApiDtoInterface */
        $entity
            ->setRouteParameters($dto->getRouteParameters())
            ->setAttributes($dto->getAttributes())
            ->setTag($dto->getTag())
            ->setRoles($dto->getRoles())
            ->setName($dto->getName());

        foreach ($entity->getChildren() as $child) {
            $child->setParent();
        }

        if ($dto->hasChildMenuApiDto()) {
            foreach ($dto->getChildMenuApiDto() as $child) {
                /* @var $child MenuApiDtoInterface */
                try {
                    $menu = $this->repository->find($child->getId());
                } catch (MenuNotFoundException $e) {
                    throw new MenuCannotBeSavedException('Child element doesn\'t exist');
                }

                if ($menu->hasParent()) {
                    throw new MenuCannotBeSavedException('Child element shouldn\'t have a parent');
                }

                $menu->setParent($entity);
            }

            $entity
                ->setUri($dto->getUri())
                ->setRoute();
        } else {
            $entity
                ->setParent()
                ->setRoute($dto->getRoute())
                ->setUri();
        }

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        foreach ($entity->getChildren() as $child) {
            $child->setParent();
        }
    }

    public function onCreate(DtoInterface $dto, $entity): MenuInterface
    {
        /* @var $dto MenuApiDtoInterface */
        $entity
            ->setRouteParameters($dto->getRouteParameters())
            ->setAttributes($dto->getAttributes())
            ->setTag($dto->getTag())
            ->setRoles($dto->getRoles())
            ->setName($dto->getName());

        if ($dto->hasChildMenuApiDto()) {
            foreach ($dto->getChildMenuApiDto() as $child) {
                /* @var $child MenuApiDtoInterface */
                try {
                    $menu = $this->repository->find($child->getId());
                } catch (MenuNotFoundException $e) {
                    throw new MenuCannotBeCreatedException('Child element doesn\'t exist');
                }

                if ($menu->hasParent()) {
                    throw new MenuCannotBeCreatedException('Child element shouldn\'t have a parent');
                }

                $menu->setParent($entity);
            }

            $entity->setUri($dto->getUri());
        } else {
            $entity->setRoute($dto->getRoute());
        }

        return $entity;
    }
}
