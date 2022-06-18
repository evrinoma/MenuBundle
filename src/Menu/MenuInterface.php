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

interface MenuInterface
{
    public const DEFAULT_TAG = 'default';

    public function create(EntityManagerInterface $em): void;

    public function tag(): string;

    public function order(): int;
}
