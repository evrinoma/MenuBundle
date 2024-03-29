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

namespace Evrinoma\MenuBundle\Factory\Menu;

use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Entity\Menu\BaseMenu;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;

class Factory implements FactoryInterface
{
    private static string $entityClass = BaseMenu::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return MenuInterface
     */
    public function create(MenuApiDtoInterface $dto): MenuInterface
    {
        /* @var BaseMenu $menu */
        return new self::$entityClass();
    }
}
