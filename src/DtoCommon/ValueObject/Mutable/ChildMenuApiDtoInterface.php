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

interface ChildMenuApiDtoInterface
{
    /**
     * @param DtoInterface $dto
     *
     * @return DtoInterface
     */
    public function addChildMenuApiDto(DtoInterface $dto): DtoInterface;

    /**
     * @param DtoInterface[] $childMenuApiDto
     */
    public function setChildMenuApiDto(array $childMenuApiDto): DtoInterface;
}
