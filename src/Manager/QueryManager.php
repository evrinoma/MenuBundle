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

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Exception\MenuProxyException;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;
use Evrinoma\MenuBundle\Repository\MenuQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private MenuQueryRepositoryInterface $repository;

    public function __construct(MenuQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MenuNotFoundException
     */
    public function criteria(MenuApiDtoInterface $dto): array
    {
        try {
            $menu = $this->repository->findByCriteria($dto);
        } catch (MenuNotFoundException $e) {
            throw $e;
        }

        return $menu;
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return MenuInterface
     *
     * @throws MenuProxyException
     * @throws ORMException
     */
    public function proxy(MenuApiDtoInterface $dto): MenuInterface
    {
        try {
            if ($dto->hasId()) {
                $menu = $this->repository->proxy($dto->idToString());
            } else {
                throw new MenuProxyException('Id value is not set while trying get proxy object');
            }
        } catch (MenuProxyException $e) {
            throw $e;
        }

        return $menu;
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return MenuInterface
     *
     * @throws MenuNotFoundException
     */
    public function get(MenuApiDtoInterface $dto): MenuInterface
    {
        try {
            $menu = $this->repository->find($dto->getId());
        } catch (MenuNotFoundException $e) {
            throw $e;
        }

        return $menu;
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MenuNotFoundException
     */
    public function tags(MenuApiDtoInterface $dto): array
    {
        try {
            $tags = $this->repository->findTags($dto);
        } catch (MenuNotFoundException $e) {
            throw $e;
        }

        return $tags;
    }
}
