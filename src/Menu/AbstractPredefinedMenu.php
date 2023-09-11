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

namespace Evrinoma\MenuBundle\Menu;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MenuBundle\Dto\Preserve\MenuApiDto;
use Evrinoma\SecurityBundle\Voter\RoleInterface;

abstract class AbstractPredefinedMenu
{
    protected static string $dtoClass = MenuApiDto::class;

    public function __construct(string $dtoClass)
    {
        self::$dtoClass = $dtoClass;
    }

    public function create(): DtoInterface
    {
        $logout = new self::$dtoClass();
        $logout
            ->setName('Logout')
            ->setRoles([RoleInterface::ROLE_SUPER_ADMIN, RoleInterface::ROLE_USER])
            ->setRoute('security_logout')
            ->setAttributes(['class' => 'logout'])
            ->setTag($this->tag());

        return $logout;
    }
}
