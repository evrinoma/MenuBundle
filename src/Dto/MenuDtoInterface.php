<?php

namespace Evrinoma\MenuBundle\Dto;

interface MenuDtoInterface
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