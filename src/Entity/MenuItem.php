<?php

namespace Evrinoma\MenuBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\RelationTrait;
use Evrinoma\UtilsBundle\Entity\RoleTrait;

/**
 * Class MenuItem
 *
 * @package Evrinoma\MenuBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="menu_items")
 */
class MenuItem
{
    use IdTrait, RelationTrait, RoleTrait;

//region SECTION: Fields
    /**
     * @var MenuItem
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\MenuBundle\Entity\MenuItem", inversedBy="children")
     */
    protected $parent = null;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Evrinoma\MenuBundle\Entity\MenuItem", mappedBy="parent")
     */
    protected $children = null;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    protected $name = '';

    /**
     * @var string
     * @ORM\Column(name="route", type="string", nullable=true)
     */
    protected $route = null;

    /**
     * @var array
     * @ORM\Column(name="routeParameters ", type="array", nullable=true)
     */
    protected $routeParameters = null;

    /**
     * @var string
     * @ORM\Column(name="uri", type="string", nullable=true)
     */
    protected $uri = null;

    /**
     * @var array
     * @ORM\Column(name="attributes", type="array", nullable=true)
     */
    protected $attributes = null;

    /**
     * @var array
     * @ORM\Column(name="role", type="array", nullable=true)
     */
    protected $role = null;

    /**
     * @var string
     * @ORM\Column(name="tag", type="string")
     */
    protected $tag;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * @return array
     */
    public function getRouteParameters(): ?array
    {
        return $this->routeParameters;
    }

    /**
     * @return string
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    /**
     * @return array|null
     */
    public function toRoute(): array
    {
        return $this->getRoute() ? ['route' => $this->getRoute()] : [];
    }

    /**
     * @return array|null
     */
    public function toUri(): ?array
    {
        return $this->getUri() ? ['uri' => $this->getUri()] : [];
    }

    /**
     * @return array|null
     */
    public function toRouteParameters(): array
    {
        return $this->getRouteParameters() ? ['routeParameters' => $this->getRouteParameters()] : [];
    }

    /**
     * @return array|null
     */
    public function toAttributes(): array
    {
        return $this->getAttributes() ? ['attributes' => $this->getAttributes()] : [];
    }

    public function getOptions()
    {
        return $this->toUri() + $this->toRoute() + $this->toAttributes() + $this->toRouteParameters();
    }

    /**
     * @param string $tag
     *
     * @return MenuItem
     */
    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @param $id
     *
     * @return MenuItem
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return MenuItem
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $route
     *
     * @return MenuItem
     */
    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @param string $uri
     *
     * @return MenuItem
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return MenuItem
     */
    public function setAttributes($attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param array $routeParameters
     *
     * @return MenuItem
     */
    public function setRouteParameters(array $routeParameters): self
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }
//endregion Getters/Setters
}