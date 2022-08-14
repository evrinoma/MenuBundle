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
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Repository\AliasInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\UtilsBundle\Mediator\OrmQueryMediator;
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
    use OrmQueryMediator;

    protected static string $alias = AliasInterface::MENU;

    /**
     * @param DtoInterface $dto
     * @param QueryBuilder $builder
     *
     * @return mixed
     */
    public function createQuery(DtoInterface $dto, QueryBuilderInterface $builder): void
    {
        $alias = $this->alias();

        /** @var $dto MenuApiDtoInterface */
        if ($dto->hasId()) {
            $builder
                ->andWhere($alias.'.id = :id')
                ->setParameter('id', $dto->getId());
        }
        if ($dto->hasTag()) {
            $builder
                ->andWhere($alias.'.tag = :tag')
                ->setParameter('tag', $dto->getTag());
        }
        if ($dto->hasRoute()) {
            $builder
                ->andWhere($alias.'.route = :route')
                ->setParameter('route', $dto->getRoute());
        }
        if ($dto->hasName()) {
            $builder
                ->andWhere($alias.'.name like :name')
                ->setParameter('name', '%'.$dto->getName().'%');
        }
        if ($dto->hasRoot() && $dto->isRoot()) {
            $builder
                ->andWhere($alias.'.parent is NULL');
        }
    }

    public function createQueryTag(MenuApiDtoInterface $dto, QueryBuilderInterface $builder): void
    {
        $alias = $this->alias();

        $builder
            ->select($alias.'.tag')
            ->groupBy($alias.'.tag');
    }

    public function getResultTag(MenuApiDtoInterface $dto, QueryBuilderInterface $builder): array
    {
        return array_column($this->getResult($dto, $builder), 'tag');
    }
}
