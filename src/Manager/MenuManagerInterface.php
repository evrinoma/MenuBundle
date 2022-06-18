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

use Evrinoma\UtilsBundle\Manager\EntityInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

/**
 * @deprecated
 */
interface MenuManagerInterface extends RestInterface, EntityInterface
{
    public function setDto($dto): MenuManagerInterface;

    public function get($options = []): MenuManagerInterface;

    public function delete(): void;

    public function create(): void;
}
