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

use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuTagNotFoundException;

interface MenuRawRepositoryInterface
{
    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MenuTagNotFoundException
     */
    public function findTags(MenuApiDtoInterface $dto): array;
}
