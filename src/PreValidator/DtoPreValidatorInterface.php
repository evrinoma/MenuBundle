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

use Evrinoma\MenuBundle\Dto\MenuDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param MenuDtoInterface $dto
     *
     * @throws MenuInvalidException
     */
    public function onPost(MenuDtoInterface $dto): void;

    /**
     * @param MenuDtoInterface $dto
     *
     * @throws MenuInvalidException
     */
    public function onPut(MenuDtoInterface $dto): void;

    /**
     * @param MenuDtoInterface $dto
     *
     * @throws MenuInvalidException
     */
    public function onDelete(MenuDtoInterface $dto): void;
}
