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
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\AttributesTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\RolesTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\RouteTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\TagTrait;
use Evrinoma\MenuBundle\DtoCommon\ValueObject\Mutable\UriTrait;
use Symfony\Component\HttpFoundation\Request;

class MenuApiDto extends AbstractDto implements MenuApiDtoInterface
{
    use AttributesTrait;
    use IdTrait;
    use NameTrait;
    use RolesTrait;
    use RouteTrait;
    use TagTrait;
    use UriTrait;

    /**
     * @Dtos(class="Evrinoma\MenuBundle\Dto\MenuApiDto", generator="genRequestChildMenuApiDto", add="addChildMenuApiDto")
     *
     * @var MenuApiDtoInterface[]
     */
    private array $childMenuApiDto = [];

    /**
     * @return MenuApiDtoInterface[]
     */
    public function getChildMenuApiDto(): array
    {
        return $this->childMenuApiDto;
    }

    /**
     * @param MenuApiDtoInterface[] $childMenuApiDto
     */
    public function setChildMenuApiDto(array $childMenuApiDto): DtoInterface
    {
        $this->childMenuApiDto = $childMenuApiDto;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasChildMenuApiDto(): bool
    {
        return null !== $this->childMenuApiDto;
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
            $id = $request->get(MenuApiDtoInterface::ID, -1);
            $attributes = $request->get(MenuApiDtoInterface::ATTRIBUTES, []);
            $roles = $request->get(MenuApiDtoInterface::ROLES, []);
            if ($id) {
                $this->setId((int) $id);
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
        }

        return $this;
    }

    /**
     * @return \Generator
     */
    public function genRequestChildMenuApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $child = $request->get(MenuApiDtoInterface::CHILDREN);
            if ($child) {
                foreach ($child as $menu) {
                    $newRequest = $this->getCloneRequest();
                    $menu[DtoInterface::DTO_CLASS] = MenuApiDto::class;
                    $newRequest->request->add($menu);

                    yield $newRequest;
                }
            }
        }
    }

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @return DtoInterface
     */
    public function addChildMenuApiDto(MenuApiDtoInterface $dto): DtoInterface
    {
        $this->childMenuApiDto[] = $dto;

        return $this;
    }
}
