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

use Doctrine\ORM\QueryBuilder;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;

interface TagQueryMediatorInterface
{
    /**
     * @param MenuApiDtoInterface $dto
     * @param QueryBuilder        $builder
     *
     * @return mixed
     */
    public function createQueryTag(MenuApiDtoInterface $dto, QueryBuilder $builder): void;

    /**
     * @param MenuApiDtoInterface $dto
     * @param QueryBuilder        $builder
     *
     * @return array
     */
    public function getResultTag(MenuApiDtoInterface $dto, QueryBuilder $builder): array;
}
