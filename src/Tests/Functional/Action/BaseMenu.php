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

namespace Evrinoma\MenuBundle\Tests\Functional\Action;

use Evrinoma\MenuBundle\Dto\MenuApiDto;
use Evrinoma\MenuBundle\Tests\Functional\Helper\BaseMenuTestTrait;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;

class BaseMenu extends AbstractServiceTest implements BaseMenuTestInterface
{
    use BaseMenuTestTrait;

    public const API_GET = 'evrinoma/api/menu';
    public const API_CRITERIA = 'evrinoma/api/menu/criteria';
    public const API_DELETE = 'evrinoma/api/menu/delete';
    public const API_PUT = 'evrinoma/api/menu/save';
    public const API_POST = 'evrinoma/api/menu/create';

    protected static function getDtoClass(): string
    {
        return MenuApiDto::class;
    }

    protected static function defaultData(): array
    {
        return [
            'class' => static::getDtoClass(),
        ];
    }

    public function actionPost(): void
    {
    }

    public function actionCriteriaNotFound(): void
    {
    }

    public function actionCriteria(): void
    {
    }

    public function actionDelete(): void
    {
    }

    public function actionPut(): void
    {
    }

    public function actionGet(): void
    {
    }

    public function actionGetNotFound(): void
    {
    }

    public function actionDeleteNotFound(): void
    {
    }

    public function actionDeleteUnprocessable(): void
    {
    }

    public function actionPutNotFound(): void
    {
    }

    public function actionPutUnprocessable(): void
    {
    }

    public function actionPostDuplicate(): void
    {
    }

    public function actionPostUnprocessable(): void
    {
    }
}
