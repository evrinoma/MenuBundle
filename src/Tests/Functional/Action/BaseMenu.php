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
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Registry\ObjectInterface;
use Evrinoma\MenuBundle\Tests\Functional\Helper\BaseMenuTestTrait;
use Evrinoma\MenuBundle\Tests\Functional\ValueObject\Menu\Id;
use Evrinoma\MenuBundle\Tests\Functional\ValueObject\Menu\Name;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\Rest\ErrorModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

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
            MenuApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            MenuApiDtoInterface::ID => Id::default(),
            MenuApiDtoInterface::ROUTE_PARAMETERS => ['alias', 'cam'],
            MenuApiDtoInterface::ATTRIBUTES => ['D' => 'd', 'E' => 'e', 'F' => 'f'],
            MenuApiDtoInterface::ROUTE => 'core_home',
            MenuApiDtoInterface::NAME => Name::value(),
            MenuApiDtoInterface::ROLES => ['A', 'B', 'C'],
            MenuApiDtoInterface::URI => '#',
            MenuApiDtoInterface::TAG => ObjectInterface::DEFAULT_TAG,
            MenuApiDtoInterface::CHILD_MENU => [[MenuApiDtoInterface::ID => id::value()]],
        ];
    }

    public function actionPost(): void
    {
        $this->createMenu();
        $this->testResponseStatusCreated();

        $query = static::getDefault([MenuApiDtoInterface::NAME => 'nameA', MenuApiDtoInterface::CHILD_MENU => [[MenuApiDtoInterface::ID => '1'], [MenuApiDtoInterface::ID => '2']]]);
        $this->post($query);
        $this->testResponseStatusCreated();

        $query = static::getDefault([MenuApiDtoInterface::NAME => 'nameB', MenuApiDtoInterface::CHILD_MENU => []]);

        $this->post($query);
        $this->testResponseStatusCreated();

        $query = static::getDefault([MenuApiDtoInterface::NAME => 'nameC']);
        unset($query[MenuApiDtoInterface::CHILD_MENU]);
        $this->post($query);
        $this->testResponseStatusCreated();
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value(), Response::HTTP_NOT_FOUND);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $this->delete(Id::empty());
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $updated = $this->put(static::getDefault([MenuApiDtoInterface::ID => Id::wrong()]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $updated = $this->put(static::getDefault([MenuApiDtoInterface::ID => Id::empty()]));
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query[MenuApiDtoInterface::ROLES]);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query[MenuApiDtoInterface::NAME]);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query[MenuApiDtoInterface::TAG]);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query[MenuApiDtoInterface::ROUTE]);
        unset($query[MenuApiDtoInterface::CHILD_MENU]);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query[MenuApiDtoInterface::ROUTE]);
        unset($query[MenuApiDtoInterface::URI]);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query[MenuApiDtoInterface::ROUTE]);
        $this->post(static::getDefault([MenuApiDtoInterface::CHILD_MENU => [[MenuApiDtoInterface::ID => Id::empty()]]]));
        $this->testResponseStatusUnprocessable();
    }

    public function actionCriteriaNotFound(): void
    {
        $query = static::getDefault([MenuApiDtoInterface::NAME => Name::wrong()]);
        unset($query[MenuApiDtoInterface::TAG]);
        unset($query[MenuApiDtoInterface::ROUTE]);
        unset($query[MenuApiDtoInterface::ID]);

        $response = $this->criteria($query);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(ErrorModel::ERROR, $response);

        $query = static::getDefault([MenuApiDtoInterface::ID => Id::wrong()]);
        unset($query[MenuApiDtoInterface::TAG]);
        unset($query[MenuApiDtoInterface::ROUTE]);
        unset($query[MenuApiDtoInterface::NAME]);

        $response = $this->criteria($query);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(ErrorModel::ERROR, $response);
    }

    public function actionCriteria(): void
    {
        $query = static::getDefault();
        unset($query[MenuApiDtoInterface::TAG]);
        unset($query[MenuApiDtoInterface::ROUTE]);
        unset($query[MenuApiDtoInterface::NAME]);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(1, $response[PayloadModel::PAYLOAD]);
        $entity = $response[PayloadModel::PAYLOAD][0];
        $this->checkMenu($entity);
        Assert::assertEquals($entity[MenuApiDtoInterface::ID], $query[MenuApiDtoInterface::ID]);

        $query = static::getDefault();
        unset($query[MenuApiDtoInterface::ID]);
        unset($query[MenuApiDtoInterface::ROUTE]);
        unset($query[MenuApiDtoInterface::NAME]);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(6, $response[PayloadModel::PAYLOAD]);
        foreach ($response[PayloadModel::PAYLOAD] as $entity) {
            $this->checkMenu($entity);
            Assert::assertEquals($entity[MenuApiDtoInterface::TAG], $query[MenuApiDtoInterface::TAG]);
        }

        $query = static::getDefault();
        $query[MenuApiDtoInterface::ROUTE] = 'route_test_0';
        unset($query[MenuApiDtoInterface::ID]);
        unset($query[MenuApiDtoInterface::TAG]);
        unset($query[MenuApiDtoInterface::NAME]);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(1, $response[PayloadModel::PAYLOAD]);
        $entity = $response[PayloadModel::PAYLOAD][0];
        $this->checkMenu($entity);
        Assert::assertEquals($entity[MenuApiDtoInterface::ROUTE], $query[MenuApiDtoInterface::ROUTE]);

        $query = static::getDefault();
        $query[MenuApiDtoInterface::NAME] = Name::default();
        unset($query[MenuApiDtoInterface::ID]);
        unset($query[MenuApiDtoInterface::TAG]);
        unset($query[MenuApiDtoInterface::ROUTE]);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(12, $response[PayloadModel::PAYLOAD]);
        foreach ($response[PayloadModel::PAYLOAD] as $entity) {
            $this->checkMenu($entity);
            Assert::assertThat(strtolower($entity[MenuApiDtoInterface::NAME]), Assert::stringContains(strtolower($query[MenuApiDtoInterface::NAME])));
        }

        $query = static::getDefault();
        $query[MenuApiDtoInterface::ROUTE] = true;
        unset($query[MenuApiDtoInterface::ID]);
        unset($query[MenuApiDtoInterface::TAG]);
        unset($query[MenuApiDtoInterface::ROUTE]);
        unset($query[MenuApiDtoInterface::NAME]);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(12, $response[PayloadModel::PAYLOAD]);
        foreach ($response[PayloadModel::PAYLOAD] as $entity) {
            Assert::assertArrayNotHasKey('parent', $response);
            $this->checkMenu($entity);
        }
    }

    public function actionPut(): void
    {
        $find = $this->assertGet(Id::value());

        $query = static::getDefault([MenuApiDtoInterface::ID => Id::value()]);
        unset($query[MenuApiDtoInterface::CHILD_MENU]);

        $updated = $this->put($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $updated);
        Assert::assertNotEquals($updated[PayloadModel::PAYLOAD], $find[PayloadModel::PAYLOAD]);

        $criteria = $this->get(Id::value());
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $criteria);
        Assert::assertEquals($updated[PayloadModel::PAYLOAD], $criteria[PayloadModel::PAYLOAD]);

        $find = $this->assertGet(Id::default());

        $query = static::getDefault([MenuApiDtoInterface::ID => Id::default(),  MenuApiDtoInterface::CHILD_MENU => array_merge($find[PayloadModel::PAYLOAD][0]['children'], [[MenuApiDtoInterface::ID => Id::value()]])]);

        $updated = $this->put($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $updated);
        Assert::assertNotEquals($updated[PayloadModel::PAYLOAD], $find[PayloadModel::PAYLOAD]);

        $criteria = $this->get(Id::default());
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $criteria);

        Assert::assertArrayHasKey('children', $criteria[PayloadModel::PAYLOAD][0]);
        usort($criteria[PayloadModel::PAYLOAD][0]['children'], function ($a, $b) {
            return (int) ($a[MenuApiDtoInterface::ID] > $b[MenuApiDtoInterface::ID]);
        });
        Assert::assertArrayHasKey('children', $updated[PayloadModel::PAYLOAD][0]);
        usort($updated[PayloadModel::PAYLOAD][0]['children'], function ($a, $b) {
            return (int) ($a[MenuApiDtoInterface::ID] > $b[MenuApiDtoInterface::ID]);
        });

        Assert::assertEquals($updated[PayloadModel::PAYLOAD], $criteria[PayloadModel::PAYLOAD]);
    }

    public function actionPostDuplicate(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }
}
