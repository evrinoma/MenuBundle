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
use Evrinoma\MenuBundle\Exception\MenuProxyException;
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
            ->setAttributes($dto->getAttributes())
            ->setTag($dto->getTag())
            ->setRoles($dto->getRoles())
            ->setName($dto->getName())
        ;

        foreach ($entity->getChildren() as $child) {
            $child->setParent();
        }

        if ($dto->hasChildMenuApiDto()) {
            foreach ($dto->getChildMenuApiDto() as $child) {
                /* @var $child MenuApiDtoInterface */
                try {
                    if ($child->hasId()) {
                        $menu = $this->repository->proxy($dto->getId());
                    } else {
                        throw new MenuProxyException('Id value is not set while trying get proxy object');
                    }
                } catch (MenuProxyException $e) {
                    throw $e;
                }

                $menu->setParent($entity);
            }

            $entity->setUri($dto->getUri());
        } else {
            $entity->setRoute($dto->getRoute());
        }

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
    }

    public function onCreate(DtoInterface $dto, $entity): MenuInterface
    {
        /* @var $dto MenuApiDtoInterface */
        $entity
            ->setAttributes($dto->getAttributes())
            ->setTag($dto->getTag())
            ->setRoles($dto->getRoles())
            ->setName($dto->getName())
        ;

        if ($dto->hasChildMenuApiDto()) {
            foreach ($dto->getChildMenuApiDto() as $child) {
                /* @var $child MenuApiDtoInterface */
                try {
                    if ($child->hasId()) {
                        $menu = $this->repository->proxy($dto->getId());
                    } else {
                        throw new MenuProxyException('Id value is not set while trying get proxy object');
                    }
                } catch (MenuProxyException $e) {
                    throw $e;
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
