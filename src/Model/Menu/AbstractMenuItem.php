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

namespace Evrinoma\MenuBundle\Model\Menu;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\NameTrait;
use Evrinoma\UtilsBundle\Entity\RelationTrait;
use Evrinoma\UtilsBundle\Entity\RolesTrait;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractMenuItem implements MenuInterface
{
    use IdTrait;
    use NameTrait;
    use RelationTrait;
    use RolesTrait;

    /**
     * @var MenuInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\MenuBundle\Entity\MenuInterface", inversedBy="children")
     */
    protected $parent = null;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Evrinoma\MenuBundle\Entity\MenuInterface", mappedBy="parent")
     */
    protected $children = null;

    /**
     * @var string
     * @ORM\Column(name="route", type="string", nullable=true)
     */
    protected ?string $route = null;

    /**
     * @var array
     * @ORM\Column(name="routeParameters ", type="array", nullable=true)
     */
    protected ?array $routeParameters = null;

    /**
     * @var string
     * @ORM\Column(name="uri", type="string", nullable=true)
     */
    protected ?string $uri = null;

    /**
     * @var array
     * @ORM\Column(name="attributes", type="array", nullable=true)
     */
    protected ?array $attributes = null;

    /**
     * @var string
     * @ORM\Column(name="tag", type="string")
     */
    protected $tag;

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @return string|null
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * @return array|null
     */
    public function getRouteParameters(): ?array
    {
        return $this->routeParameters;
    }

    /**
     * @return string|null
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
     * @return array|null
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    /**
     * @return array
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

    public function getOptions(): array
    {
        return $this->toUri() + $this->toRoute() + $this->toAttributes() + $this->toRouteParameters();
    }

    /**
     * @param string $tag
     *
     * @return MenuInterface
     */
    public function setTag(string $tag): MenuInterface
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @param string $route
     *
     * @return MenuInterface
     */
    public function setRoute(string $route): MenuInterface
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @param string $uri
     *
     * @return MenuInterface
     */
    public function setUri(string $uri): MenuInterface
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return MenuInterface
     */
    public function setAttributes(array $attributes): MenuInterface
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param array $routeParameters
     *
     * @return MenuInterface
     */
    public function setRouteParameters(array $routeParameters): MenuInterface
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }
}
