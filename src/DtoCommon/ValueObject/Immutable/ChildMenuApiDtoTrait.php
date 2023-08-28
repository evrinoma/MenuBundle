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
            $entities = $request->get(ChildMenuApiDtoInterface::CHILD_MENU);
            if ($entities) {
                foreach ($entities as $entity) {
                    yield $this->toRequest($entity, static::$classMenusApiDto);
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
