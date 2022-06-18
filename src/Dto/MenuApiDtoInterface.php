<?php

namespace Evrinoma\MenuBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface MenuApiDtoInterface extends DtoInterface, IdInterface
{
    public const TAG = 'tag';

    /**
     * @return string
     */
    public function getTag(): string;

    /**
     * @return bool
     */
    public function hasTag(): bool;
}