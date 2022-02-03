<?php

namespace Evrinoma\MenuBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface MenuDtoInterface extends DtoInterface
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