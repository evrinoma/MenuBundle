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

namespace Evrinoma\MenuBundle\Dto;

use Evrinoma\DtoBundle\Annotation\Dtos;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\AttributesTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\ChildMenuApiDtoTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\RolesTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\RootTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\RouteParametersTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\RouteTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\TagTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\UriTrait;
use Symfony\Component\HttpFoundation\Request;

class MenuApiDto extends AbstractDto implements MenuApiDtoInterface
{
    use AttributesTrait;
    use ChildMenuApiDtoTrait;
    use IdTrait;
    use NameTrait;
    use RolesTrait;
    use RootTrait;
    use RouteParametersTrait;
    use RouteTrait;
    use TagTrait;
    use UriTrait;

    /**
     * @Dtos(class="Evrinoma\MenuBundle\Dto\MenuApiDto", generator="genRequestChildMenuApiDto", add="addChildMenuApiDto")
     *
     * @var MenuApiDtoInterface[]
     */
    protected array $childMenuApiDto = [];

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return DtoInterface
     */
    public function addChildMenuApiDto(DtoInterface $dto): DtoInterface
    {
        $this->childMenuApiDto[] = $dto;

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $tag = $request->get(MenuApiDtoInterface::TAG);
            $name = $request->get(MenuApiDtoInterface::NAME);
            $uri = $request->get(MenuApiDtoInterface::URI);
            $route = $request->get(MenuApiDtoInterface::ROUTE);
            $id = $request->get(MenuApiDtoInterface::ID);
            $attributes = $request->get(MenuApiDtoInterface::ATTRIBUTES, []);
            $roles = $request->get(MenuApiDtoInterface::ROLES, []);
            $root = $request->get(MenuApiDtoInterface::ROOT);
            if ($id) {
                $this->setId($id);
            }
            if ($name) {
                $this->setName($name);
            }
            if ($uri) {
                $this->setUri($uri);
            }
            if ($roles) {
                $this->setRoles($roles);
            }
            if ($attributes) {
                $this->setAttributes($attributes);
            }
            if ($route) {
                $this->setRoute($route);
            }
            if ($tag) {
                $this->setTag($tag);
            }
            if (isset($root)) {
                $this->setRoot();
            }
        }

        return $this;
    }
}
