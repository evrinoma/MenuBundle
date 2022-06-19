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

trait UriTrait
{
    private string $uri = '';

    /**
     * @return bool
     */
    public function hasUri(): bool
    {
        return '' !== $this->uri;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
