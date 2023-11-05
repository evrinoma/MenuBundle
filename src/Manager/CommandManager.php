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
use Evrinoma\MenuBundle\Exception\MenuCannotBeCreatedException;
use Evrinoma\MenuBundle\Exception\MenuCannotBeRemovedException;
use Evrinoma\MenuBundle\Exception\MenuCannotBeSavedException;
use Evrinoma\MenuBundle\Exception\MenuInvalidException;
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Factory\Menu\FactoryInterface;
use Evrinoma\MenuBundle\Mediator\CommandMediatorInterface;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;
use Evrinoma\MenuBundle\Repository\Menu\MenuRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private MenuRepositoryInterface $repository;
    private ValidatorInterface $validator;
    private FactoryInterface $factory;
    private CommandMediatorInterface $mediator;

    /**
     * @param ValidatorInterface       $validator
     * @param MenuRepositoryInterface  $repository
     * @param FactoryInterface         $factory
     * @param CommandMediatorInterface $mediator
     */
    public function __construct(ValidatorInterface $validator, MenuRepositoryInterface $repository, FactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return MenuInterface
     *
     * @throws MenuInvalidException
     * @throws MenuCannotBeCreatedException
     * @throws MenuCannotBeSavedException
     */
    public function post(MenuApiDtoInterface $dto): MenuInterface
    {
        $menu = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $menu);

        $errors = $this->validator->validate($menu);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new MenuInvalidException($errorsString);
        }

        $this->repository->save($menu);

        return $menu;
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return MenuInterface
     *
     * @throws MenuInvalidException
     * @throws MenuNotFoundException
     * @throws MenuCannotBeSavedException
     */
    public function put(MenuApiDtoInterface $dto): MenuInterface
    {
        try {
            $menu = $this->repository->find($dto->idToString());
        } catch (MenuNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $menu);

        $errors = $this->validator->validate($menu);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new MenuInvalidException($errorsString);
        }

        $this->repository->save($menu);

        return $menu;
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @throws MenuCannotBeRemovedException
     * @throws MenuNotFoundException
     */
    public function delete(MenuApiDtoInterface $dto): void
    {
        try {
            $menu = $this->repository->find($dto->idToString());
        } catch (MenuNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $menu);
        try {
            $this->repository->remove($menu);
        } catch (MenuCannotBeRemovedException $e) {
            throw $e;
        }
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @throws MenuCannotBeRemovedException
     * @throws MenuNotFoundException
     */
    public function remove(MenuApiDtoInterface $dto): void
    {
        try {
            $menuItems = $this->repository->findByCriteria($dto);
        } catch (MenuNotFoundException $e) {
            throw $e;
        }
        foreach ($menuItems as $menu) {
            $this->mediator->onDelete($dto, $menu);
            try {
                $this->repository->remove($menu);
            } catch (MenuCannotBeRemovedException $e) {
                throw $e;
            }
        }
    }
}
