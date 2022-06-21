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

use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\UtilsBundle\Entity\NameInterface;
use Evrinoma\UtilsBundle\Entity\RelationInterface;
use Evrinoma\UtilsBundle\Entity\RolesInterface;

interface MenuInterface extends IdInterface, RolesInterface, RelationInterface, NameInterface
{
    /**
     * @return string
     */
    public function getTag(): string;

    /**
     * @return string|null
     */
    public function getRoute(): ?string;

    /**
     * @return array|null
     */
    public function getRouteParameters(): ?array;

    /**
     * @return string|null
     */
    public function getUri(): ?string;

    /**
     * @return array|null
     */
    public function getAttributes(): ?array;

    /**
     * @return array
     */
    public function toRoute(): array;

    /**
     * @return array|null
     */
    public function toUri(): ?array;

    /**
     * @return array
     */
    public function toRouteParameters(): array;

    /**
     * @return array
     */
    public function toAttributes(): array;

    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @param string $tag
     *
     * @return MenuInterface
     */
    public function setTag(string $tag): MenuInterface;

    /**
     * @param string|null $route
     *
     * @return MenuInterface
     */
    public function setRoute(string $route = null): MenuInterface;

    /**
     * @param string|null $uri
     *
     * @return MenuInterface
     */
    public function setUri(string $uri = null): MenuInterface;

    /**
     * @param array $attributes
     *
     * @return MenuInterface
     */
    public function setAttributes(array $attributes): MenuInterface;

    /**
     * @param array $routeParameters
     *
     * @return MenuInterface
     */
    public function setRouteParameters(array $routeParameters): MenuInterface;
}
