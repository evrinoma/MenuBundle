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

namespace Evrinoma\MenuBundle\Mediator;

use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

interface RawMediatorInterface
{
    /**
     * @param MenuApiDtoInterface   $dto
     * @param QueryBuilderInterface $builder
     *
     * @return mixed
     */
    public function createQueryTag(MenuApiDtoInterface $dto, QueryBuilderInterface $builder): void;

    /**
     * @param MenuApiDtoInterface   $dto
     * @param QueryBuilderInterface $builder
     *
     * @return array
     */
    public function getResultTag(MenuApiDtoInterface $dto, QueryBuilderInterface $builder): array;
}
