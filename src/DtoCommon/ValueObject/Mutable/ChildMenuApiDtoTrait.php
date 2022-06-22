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
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable\ChildMenuApiDtoTrait as ChildMenuApiDtoImmutableTrait;

trait ChildMenuApiDtoTrait
{
    use ChildMenuApiDtoImmutableTrait;

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return DtoInterface
     */
    public function addChildMenuApiDto(MenuApiDtoInterface $dto): DtoInterface
    {
        $this->childMenuApiDto[] = $dto;

        return $this;
    }

    /**
     * @param MenuApiDtoInterface[] $childMenuApiDto
     */
    protected function setChildMenuApiDto(array $childMenuApiDto): DtoInterface
    {
        $this->childMenuApiDto = $childMenuApiDto;

        return $this;
    }
}
