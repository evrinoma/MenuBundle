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

use Doctrine\ORM\ORMException;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Exception\MenuProxyException;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;
use Evrinoma\MenuBundle\Repository\MenuQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

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
                $menu = $this->repository->proxy((string) $dto->getId());
            } else {
                throw new MenuProxyException('Id value is not set while trying get proxy object');
            }
        } catch (MenuProxyException $e) {
            throw $e;
        }

        return $menu;
    }

    public function getRestStatus(): int
    {
        return $this->status;
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
}
