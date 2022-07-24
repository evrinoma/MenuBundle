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

namespace Evrinoma\MenuBundle\Registry;

use Evrinoma\MenuBundle\Exception\ObjetRegistryException;

final class ObjectRegistry implements ObjectRegistryInterface
{
    /**
     * @var ObjectInterface[][]
     */
    private array $menuItems = [];

    public function addObject(ObjectInterface $item): void
    {
        if (!\array_key_exists($item->order(), $this->menuItems)) {
            $this->menuItems[$item->tag()][$item->order()] = $item;
        } else {
            throw new ObjetRegistryException('The Object '.\get_class($item).'trying to override another Object');
        }
    }

    public function getObjects(): \Generator
    {
        if (\count($this->menuItems)) {
            foreach ($this->menuItems as $tag) {
                if (\count($tag)) {
                    ksort($tag);
                    yield $tag;
                }
            }
        }
    }
}
