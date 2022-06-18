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

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\FcrBundle\Dto\FcrApiDtoInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuApiDto extends AbstractDto implements MenuDtoInterface
{
    use IdTrait;
    /**
     * @var string
     */
    protected string $tag = '';

    /**
     * @return bool
     */
    public function hasTag(): bool
    {
        return '' !== $this->tag;
    }

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
            $id = $request->get(FcrApiDtoInterface::ID, -1);
            if ($id) {
                $this->setId((int) $id);
            }
            if ($tag) {
                $this->setTag($tag);
            }
        }

        return $this;
    }

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
     * @return DtoInterface
     */
    public function setTag($tag): DtoInterface
    {
        $this->tag = $tag;

        return $this;
    }
}
