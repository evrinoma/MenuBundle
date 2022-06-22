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
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Exception\MenuProxyException;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;

interface QueryManagerInterface
{
    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MenuNotFoundException
     */
    public function criteria(MenuApiDtoInterface $dto): array;

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return MenuInterface
     *
     * @throws MenuNotFoundException
     */
    public function get(MenuApiDtoInterface $dto): MenuInterface;

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return MenuInterface
     *
     * @throws MenuProxyException
     */
    public function proxy(MenuApiDtoInterface $dto): MenuInterface;

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return array
     */
    public function tags(MenuApiDtoInterface $dto): array;
}
