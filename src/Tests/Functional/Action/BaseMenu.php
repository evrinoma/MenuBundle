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
            'class' => static::getDtoClass(),
            'id' => Id::default(),
            'route_parameters' => ['alias', 'cam'],
            'attributes' => ['D' => 'd', 'E' => 'e', 'F' => 'f'],
            'route' => 'core_home',
            'name' => Name::value(),
            'roles' => ['A', 'B', 'C'],
            'uri' => '#',
            'tag' => ObjectInterface::DEFAULT_TAG,
            'child_menu' => [['id' => id::value()]],
        ];
    }

    public function actionPost(): void
    {
        $this->createMenu();
        $this->testResponseStatusCreated();

        $query = static::getDefault(['name' => 'nameA', 'child_menu' => [['id' => '1'], ['id' => '2']]]);
        $this->post($query);
        $this->testResponseStatusCreated();

        $query = static::getDefault(['name' => 'nameB', 'child_menu' => []]);

        $this->post($query);
        $this->testResponseStatusCreated();

        $query = static::getDefault(['name' => 'nameC']);
        unset($query['child_menu']);
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
        $updated = $this->put(static::getDefault(['id' => Id::wrong()]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $updated = $this->put(static::getDefault(['id' => Id::empty()]));
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query['roles']);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query['name']);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query['tag']);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query['route']);
        unset($query['child_menu']);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query['route']);
        unset($query['uri']);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query['route']);
        $this->post(static::getDefault(['child_menu' => [['id' => Id::empty()]]]));
        $this->testResponseStatusUnprocessable();
    }

    public function actionCriteriaNotFound(): void
    {
        $query = static::getDefault(['name' => Name::wrong()]);
        unset($query['tag']);
        unset($query['route']);
        unset($query['id']);

        $response = $this->criteria($query);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(ErrorModel::ERROR, $response);

        $query = static::getDefault(['id' => Id::wrong()]);
        unset($query['tag']);
        unset($query['route']);
        unset($query['name']);

        $response = $this->criteria($query);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(ErrorModel::ERROR, $response);
    }

    public function actionCriteria(): void
    {
        $query = static::getDefault();
        unset($query['tag']);
        unset($query['route']);
        unset($query['name']);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(1, $response[PayloadModel::PAYLOAD]);
        $entity = $response[PayloadModel::PAYLOAD][0];
        $this->checkMenu($entity);
        Assert::assertEquals($entity['id'], $query['id']);

        $query = static::getDefault();
        unset($query['id']);
        unset($query['route']);
        unset($query['name']);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(6, $response[PayloadModel::PAYLOAD]);
        foreach ($response[PayloadModel::PAYLOAD] as $entity) {
            $this->checkMenu($entity);
            Assert::assertEquals($entity['tag'], $query['tag']);
        }

        $query = static::getDefault();
        $query['route'] = 'route_test_0';
        unset($query['id']);
        unset($query['tag']);
        unset($query['name']);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(1, $response[PayloadModel::PAYLOAD]);
        $entity = $response[PayloadModel::PAYLOAD][0];
        $this->checkMenu($entity);
        Assert::assertEquals($entity['route'], $query['route']);

        $query = static::getDefault();
        $query['name'] = Name::default();
        unset($query['id']);
        unset($query['tag']);
        unset($query['route']);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(12, $response[PayloadModel::PAYLOAD]);
        foreach ($response[PayloadModel::PAYLOAD] as $entity) {
            $this->checkMenu($entity);
            Assert::assertThat(strtolower($entity['name']), Assert::stringContains(strtolower($query['name'])));
        }

        $query = static::getDefault();
        $query['root'] = true;
        unset($query['id']);
        unset($query['tag']);
        unset($query['route']);
        unset($query['name']);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(8, $response[PayloadModel::PAYLOAD]);
        foreach ($response[PayloadModel::PAYLOAD] as $entity) {
            Assert::assertArrayNotHasKey('parent', $response);
            $this->checkMenu($entity);
        }
    }

    public function actionPut(): void
    {
        $find = $this->assertGet(Id::value());

        $query = static::getDefault(['id' => Id::value()]);
        unset($query['child_menu']);

        $updated = $this->put($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $updated);
        Assert::assertNotEquals($updated[PayloadModel::PAYLOAD], $find[PayloadModel::PAYLOAD]);

        $criteria = $this->get(Id::value());
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $criteria);
        Assert::assertEquals($updated[PayloadModel::PAYLOAD], $criteria[PayloadModel::PAYLOAD]);

        $find = $this->assertGet(Id::default());

        $query = static::getDefault(['id' => Id::default(),  'child_menu' => array_merge($find[PayloadModel::PAYLOAD][0]['children'], [['id' => Id::value()]])]);

        $updated = $this->put($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $updated);
        Assert::assertNotEquals($updated[PayloadModel::PAYLOAD], $find[PayloadModel::PAYLOAD]);

        $criteria = $this->get(Id::default());
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $criteria);

        Assert::assertArrayHasKey('children', $criteria[PayloadModel::PAYLOAD][0]);
        usort($criteria[PayloadModel::PAYLOAD][0]['children'], function ($a, $b) {
            return (int) ($a['id'] > $b['id']);
        });
        Assert::assertArrayHasKey('children', $updated[PayloadModel::PAYLOAD][0]);
        usort($updated[PayloadModel::PAYLOAD][0]['children'], function ($a, $b) {
            return (int) ($a['id'] > $b['id']);
        });

        Assert::assertEquals($updated[PayloadModel::PAYLOAD], $criteria[PayloadModel::PAYLOAD]);
    }

    public function actionPostDuplicate(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }
}
