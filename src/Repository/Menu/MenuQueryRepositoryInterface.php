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

namespace Evrinoma\MenuBundle\Repository\Menu;

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Exception\MenuProxyException;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;

interface MenuQueryRepositoryInterface extends MenuRawRepositoryInterface
{
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
