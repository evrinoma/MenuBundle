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

namespace Evrinoma\MenuBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuCannotBeRemovedException;
use Evrinoma\MenuBundle\Exception\MenuCannotBeSavedException;
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Exception\MenuProxyException;
use Evrinoma\MenuBundle\Exception\MenuTagNotFoundException;
use Evrinoma\MenuBundle\Mediator\QueryMediatorInterface;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;

class MenuRepository extends ServiceEntityRepository implements MenuRepositoryInterface
{
    private QueryMediatorInterface $mediator;

    /**
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }

    /**
     * @param MenuInterface $menu
     *
     * @return bool
     *
     * @throws MenuCannotBeSavedException
     * @throws ORMException
     */
    public function save(MenuInterface $menu): bool
    {
        try {
            $this->getEntityManager()->persist($menu);
        } catch (ORMInvalidArgumentException $e) {
            throw new MenuCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param MenuInterface $menu
     *
     * @return bool
     *
     * @throws MenuCannotBeRemovedException
     * @throws ORMException
     */
    public function remove(MenuInterface $menu): bool
    {
        try {
            $this->getEntityManager()->remove($menu);
        } catch (ORMInvalidArgumentException $e) {
            throw new MenuCannotBeRemovedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MenuNotFoundException
     */
    public function findByCriteria(MenuApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $menus = $this->mediator->getResult($dto, $builder);

        if (0 === \count($menus)) {
            throw new MenuNotFoundException('Cannot find menu by findByCriteria');
        }

        return $menus;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws MenuNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): MenuInterface
    {
        /** @var MenuInterface $menu */
        $menu = parent::find($id);

        if (null === $menu) {
            throw new MenuNotFoundException("Cannot find menu with id $id");
        }

        return $menu;
    }

    /**
     * @param string $id
     *
     * @return MenuInterface
     *
     * @throws MenuProxyException
     * @throws ORMException
     */
    public function proxy(string $id): MenuInterface
    {
        $em = $this->getEntityManager();

        $menu = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($menu)) {
            throw new MenuProxyException("Proxy doesn't exist with $id");
        }

        return $menu;
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MenuTagNotFoundException
     */
    public function findTags(MenuApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder($this->mediator->alias());

        $this->mediator->createQueryTag($dto, $builder);

        $tags = $this->mediator->getResultTag($dto, $builder);

        if (0 === \count($tags)) {
            throw new MenuTagNotFoundException('Cannot find tags by findTags');
        }

        return $tags;
    }
}
