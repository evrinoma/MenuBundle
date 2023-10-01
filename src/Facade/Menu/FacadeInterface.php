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

namespace Evrinoma\MenuBundle\Facade\Menu;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Facade\FacadeInterface as BaseFacadeInterface;

interface FacadeInterface extends BaseFacadeInterface
{
    public function remove(DtoInterface $dto, string &$group, array &$data): void;

    public function registry(string $group, array &$data): void;
}
