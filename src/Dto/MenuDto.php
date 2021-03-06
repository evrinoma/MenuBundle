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
class MenuDto extends AbstractDto
{
//region SECTION: Fields
    /**
     * @var string
     */
    private $tag = '';
//endregion Fields

//region SECTION: Protected
    /**
     * @return mixed
     */
    protected function getClassEntity(): ?string
    {
        return null;
    }
//endregion Protected

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
            $tag = $request->get('tag');

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
     *
     * @return MenuDto
     */
    public function setTag($tag): self
    {
        $this->tag = $tag;

        return $this;
    }
//endregion Getters/Setters


}