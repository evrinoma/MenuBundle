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

namespace Evrinoma\MenuBundle\Provider;

use Evrinoma\MenuBundle\Registry\ObjectRegistryInterface;

class DtoProvider implements DtoProviderInterface
{
    private array $dtoSplitByLevel = [];
    private ObjectRegistryInterface $objectRegistry;

    public function __construct(ObjectRegistryInterface $objectRegistry)
    {
        $this->objectRegistry = $objectRegistry;
    }

    public function toDto(): DtoProviderInterface
    {
        if (0 === \count($this->dtoSplitByLevel)) {
            foreach ($this->objectRegistry->getObjects() as $tag) {
                foreach ($tag as $item) {
                    $menuApiDto = $item->create();
                    $this->recursive($menuApiDto, uniqid());
                }
            }
        }

        return $this;
    }

    public function getReverse(): \Generator
    {
        foreach (array_reverse($this->dtoSplitByLevel) as $level) {
            foreach ($level as $keyItem => $items) {
                foreach ($items as $item) {
                    yield $item;
                }
            }
        }
    }

    private function recursive($menuApiDto, $hash, $level = 0)
    {
        $this->dtoSplitByLevel[$level][$hash][] = $menuApiDto;
        if ($menuApiDto->hasChildMenuApiDto()) {
            foreach ($menuApiDto->getChildMenuApiDto() as $child) {
                $this->recursive($child, $child->hasChildMenuApiDto() ? $hash.'_'.uniqid() : $hash, $level + 1);
            }
        }
    }
}
