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

use Evrinoma\MenuBundle\Dto\Preserve\MenuApiDto;
use Evrinoma\MenuBundle\Registry\ObjectInterface;
use Evrinoma\SecurityBundle\Voter\RoleInterface;

final class PredefinedMenu implements ObjectInterface
{
    /**
     * @var string
     */
    protected static string $dtoClass = MenuApiDto::class;

    /**
     * @param string $dtoClass
     */
    public function __construct(string $dtoClass)
    {
        self::$dtoClass = $dtoClass;
    }

    public function create(): void
    {
        $logout = new self::$dtoClass();
        $logout
            ->setName('Logout')
            ->setRoles([RoleInterface::ROLE_SUPER_ADMIN, RoleInterface::ROLE_USER])
            ->setRoute('security_logout')
            ->setAttributes(['class' => 'logout'])
            ->setTag($this->tag());
    }

    public function order(): int
    {
        return 1000;
    }

    public function tag(): string
    {
        return ObjectInterface::DEFAULT_TAG;
    }
}
