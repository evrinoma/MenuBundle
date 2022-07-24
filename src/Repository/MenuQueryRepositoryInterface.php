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

use Doctrine\ORM\ORMException;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Exception\MenuProxyException;
use Evrinoma\MenuBundle\Exception\MenuTagNotFoundException;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;

interface MenuQueryRepositoryInterface
{
    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MenuTagNotFoundException
     */
    public function findTags(MenuApiDtoInterface $dto): array;

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MenuNotFoundException
     */
    public function findByCriteria(MenuApiDtoInterface $dto): array;

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return MenuInterface
     *
     * @throws MenuNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): MenuInterface;

    /**
     * @param string $id
     *
     * @return MenuInterface
     *
     * @throws MenuProxyException
     * @throws ORMException
     */
    public function proxy(string $id): MenuInterface;
}
