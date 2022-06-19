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

namespace Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\UriTrait as UriImmutableTrait;

trait UriTrait
{
    use UriImmutableTrait;

    /**
     * @param string $uri
     *
     * @return DtoInterface
     */
    protected function setUri(string $uri): DtoInterface
    {
        $this->uri = trim($uri);

        return $this;
    }
}
