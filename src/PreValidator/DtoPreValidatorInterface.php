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


use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param MenuApiDtoInterface $dto
     *
     * @throws MenuInvalidException
     */
    public function onPost(MenuApiDtoInterface $dto): void;

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @throws MenuInvalidException
     */
    public function onPut(MenuApiDtoInterface $dto): void;

    /**
     * @param MenuApiDtoInterface $dto
     *
     * @throws MenuInvalidException
     */
    public function onDelete(MenuApiDtoInterface $dto): void;
}
