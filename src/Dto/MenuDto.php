<?php

namespace Evrinoma\MenuBundle\Dto;


use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MenuDto
 *
 * @package Evrinoma\MenuBundle\Dto
 */
class MenuDto extends AbstractDto implements MenuDtoInterface
{
//region SECTION: Fields
    /**
     * @var string
     */
    protected string $tag = '';
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasTag(): bool
    {
        return $this->tag !== '';
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return AbstractDto
     */
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $tag = $request->get(MenuDtoInterface::TAG);

            if ($tag) {
                $this->setTag($tag);
            }
        }


        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag): void
    {
        $this->tag = $tag;
    }
//endregion Getters/Setters


}