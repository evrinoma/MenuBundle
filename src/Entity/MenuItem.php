<?php

namespace Evrinoma\MenuBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
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
    use RelationTrait, RoleTrait;

//region SECTION: Fields
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
//endregion Fields


//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array|null
     */
    public function getRoute(): ?array
    {
        return $this->route ? ['route' => $this->route] : null;
    }

    /**
     * @return array|null
     */
    public function getUri(): ?array
    {
        return $this->uri ? ['uri' => $this->uri] : null;
    }

    /**
     * @return array|null
     */
    public function getRouteParameters(): ?array
    {
        return $this->routeParameters ? ['routeParameters' => $this->routeParameters] : null;
    }

    /**
     * @return array|null
     */
    public function getAttributes(): ?array
    {
        return $this->attributes ? ['attributes' => $this->attributes] : null;
    }

    public function getOptions()
    {
        return (array)$this->getUri() + (array)$this->getRoute() + (array)$this->getAttributes() + (array)$this->getRouteParameters();
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