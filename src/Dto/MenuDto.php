<?php

namespace Evrinoma\MenuBundle\Dto;


use Evrinoma\DtoBundle\Dto\AbstractDto;
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
    protected function getClassEntity()
    {
        return MenuItem::class;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @param $entity
     *
     * @return mixed
     */
    public function fillEntity($entity)
    {
        return $entity;
    }

    /**
     * @return string|null
     */
    public function lookingForRequest()
    {
        return null;
    }

//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return AbstractDto
     */
    public function toDto($request)
    {
        $tag = $request->get('tag');

        if ($tag) {
            $this->setTag($tag);
        }


        return $this;
    }

    /**
     * @return string
     */
    public function getTag():string
    {
        return $this->tag;
    }

    /**
     * @return bool
     */
    public function hasTag():bool
    {
        return $this->tag !== '';
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
//endregion SECTION: Dto


}