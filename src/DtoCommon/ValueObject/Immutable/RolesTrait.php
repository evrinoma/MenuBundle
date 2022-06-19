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

namespace Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable;

trait RolesTrait
{
    private array $roles = [];

    /**
     * @return bool
     */
    public function hasRoles(): bool
    {
        return 0 !== \count($this->roles);
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}
