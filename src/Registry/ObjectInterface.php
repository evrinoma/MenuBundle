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

namespace Evrinoma\MenuBundle\Registry;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface ObjectInterface
{
    public const DEFAULT_TAG = 'default';

    public function create(): DtoInterface;

    public function tag(): string;

    public function order(): int;
}
