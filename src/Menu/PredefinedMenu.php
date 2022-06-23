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

use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Registry\ObjectInterface;
use Evrinoma\SecurityBundle\Voter\RoleInterface;

final class PredefinedMenu implements ObjectInterface
{
    public function create(EntityManagerInterface $em): void
    {
        $logout = new MenuItem();
        $logout
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN, RoleInterface::ROLE_USER])
            ->setName('Logout')
            ->setRoute('security_logout')
            ->setAttributes(['class' => 'logout'])
            ->setTag($this->tag());

        $em->persist($logout);
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
