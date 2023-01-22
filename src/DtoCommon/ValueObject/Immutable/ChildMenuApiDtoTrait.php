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

namespace Evrinoma\MenuBundle\DtoCommon\ValueObject\Immutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MenuBundle\Dto\MenuApiDto;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Symfony\Component\HttpFoundation\Request;

trait ChildMenuApiDtoTrait
{
    /**
     * @var MenuApiDtoInterface[]
     */
    protected array $childMenuApiDto = [];

    protected static string $classMenusApiDto = MenuApiDto::class;

    /**
     * @return \Generator
     */
    public function genRequestChildMenuApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $child = $request->get(ChildMenuApiDtoInterface::CHILD_MENU);
            if ($child) {
                foreach ($child as $menu) {
                    $newRequest = $this->getCloneRequest();
                    $menu[DtoInterface::DTO_CLASS] = static::$classMenusApiDto;
                    $newRequest->request->add($menu);

                    yield $newRequest;
                }
            }
        }
    }

    /**
     * @return MenuApiDtoInterface[]
     */
    public function getChildMenuApiDto(): array
    {
        return $this->childMenuApiDto;
    }

    /**
     * @return bool
     */
    public function hasChildMenuApiDto(): bool
    {
        return 0 !== \count($this->childMenuApiDto);
    }
}
