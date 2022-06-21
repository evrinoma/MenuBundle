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

namespace Evrinoma\MenuBundle\PreValidator;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this->check($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this->checkId($dto);
        $this->check($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this->checkId($dto);
    }

    private function check(DtoInterface $dto): void
    {
        /** @var MenuApiDtoInterface $dto */
        if (!$dto->hasRoles()) {
            throw new MenuInvalidException('You can\'t create menu without ROLE');
        }
        if (!$dto->hasName()) {
            throw new MenuInvalidException('You can\'t create menu without Name');
        }
        if (!$dto->hasTag()) {
            throw new MenuInvalidException('You can\'t create menu without Tag');
        }
        if ($dto->hasChildMenuApiDto()) {
            if (!$dto->hasUri()) {
                throw new MenuInvalidException('You can\'t create menu without Uri');
            }
            foreach ($dto->getChildMenuApiDto() as $child) {
                if (!$child->hasId() || !is_numeric($child->getId())) {
                    throw new MenuInvalidException('You can\'t create menu with child, cause child doesn\'t have a id or id is not a digit');
                }
            }
        } else {
            if (!$dto->hasRoute()) {
                throw new MenuInvalidException('You can\'t create menu without Route');
            }
        }
    }

    private function checkId(DtoInterface $dto): void
    {
        /** @var MenuApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new MenuInvalidException('The Dto has\'t ID or class invalid');
        }
    }
}
