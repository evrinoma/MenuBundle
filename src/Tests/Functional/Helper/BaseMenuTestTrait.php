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

namespace Evrinoma\MenuBundle\Tests\Functional\Helper;

use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\ErrorModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

trait BaseMenuTestTrait
{
    protected function assertGet(string $id, int $status = Response::HTTP_OK): array
    {
        $find = $this->get($id);

        switch ($status) {
            case Response::HTTP_OK:
                $this->testResponseStatusOK();
                $this->checkResult($find);
                break;
            case Response::HTTP_NOT_FOUND:
                $this->testResponseStatusNotFound();
                Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
                Assert::assertCount(0, $find[PayloadModel::PAYLOAD]);
                Assert::assertCount(1, $find[ErrorModel::ERROR]);
                break;
        }

        return $find;
    }

    protected function createMenu(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkMenu($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkMenu($entity): void
    {
        Assert::assertArrayHasKey(MenuApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(MenuApiDtoInterface::NAME, $entity);
        Assert::assertArrayHasKey(MenuApiDtoInterface::ROUTE_PARAMETERS, $entity);
        Assert::assertArrayHasKey(MenuApiDtoInterface::ATTRIBUTES, $entity);
        Assert::assertArrayHasKey(MenuApiDtoInterface::TAG, $entity);
        Assert::assertArrayHasKey('children', $entity);
        Assert::assertArrayHasKey(MenuApiDtoInterface::ROLES, $entity);
        if (0 === \count($entity['children'])) {
            Assert::assertArrayHasKey(MenuApiDtoInterface::ROUTE, $entity);
        } else {
            Assert::assertArrayHasKey(MenuApiDtoInterface::URI, $entity);
        }
    }
}
