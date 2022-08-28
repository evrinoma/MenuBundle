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

namespace Evrinoma\MenuBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\MenuBundle\Entity\Menu\BaseMenu;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;
use Evrinoma\MenuBundle\Registry\ObjectInterface;
use Evrinoma\SecurityBundle\Voter\RoleInterface;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class MenuFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        ['name' => 'Test_SUPER_ADMIN', 'roles' => [RoleInterface::ROLE_SUPER_ADMIN], 'attributes' => ['test_class' => 'test_logout_super_admin'], 'route_parameters' => ['param' => 'value'], 'tag' => ObjectInterface::DEFAULT_TAG, 'route' => 'route_test_0'],
        ['name' => 'Test_USER', 'roles' => [RoleInterface::ROLE_USER], 'attributes' => ['test_class' => 'test_logout_user'], 'route_parameters' => ['param' => 'value'], 'tag' => ObjectInterface::DEFAULT_TAG, 'route' => 'route_test_1'],
        ['name' => 'Test_SUPER_ADMIN', 'roles' => [RoleInterface::ROLE_SUPER_ADMIN], 'attributes' => ['test_class' => 'test_logout_super_admin'], 'route_parameters' => [], 'tag' => 'test', 'route' => 'route_test_2'],
        ['name' => 'Test_USER', 'roles' => [RoleInterface::ROLE_USER], 'attributes' => ['test_class' => 'test_logout_user'], 'route_parameters' => [], 'tag' => 'test', 'route' => 'route_test_3'],

        [
            'name' => 'Test_SUPER_ADMIN_PARENT',
            'roles' => [RoleInterface::ROLE_SUPER_ADMIN],
            'attributes' => ['test_class' => 'test_logout_super_admin'],
            'route_parameters' => [],
            'tag' => ObjectInterface::DEFAULT_TAG,
            'route' => '',
            'uri' => '#',
            'children' => [['name' => 'Test_SUPER_ADMIN_CHILD', 'roles' => [RoleInterface::ROLE_SUPER_ADMIN], 'attributes' => ['test_class' => 'test_logout_super_admin'], 'route_parameters' => ['param' => 'value'], 'tag' => ObjectInterface::DEFAULT_TAG, 'route' => 'route_test_4']],
        ],
        [
            'name' => 'Test_USER_PARENT',
            'roles' => [RoleInterface::ROLE_USER],
            'attributes' => ['test_class' => 'test_logout_user'],
            'route_parameters' => [],
            'tag' => ObjectInterface::DEFAULT_TAG,
            'route' => '',
            'uri' => '#',
            'children' => [['name' => 'Test_USER_CHILD', 'roles' => [RoleInterface::ROLE_USER], 'attributes' => ['test_class' => 'test_logout_user'], 'route_parameters' => ['param' => 'value'], 'tag' => ObjectInterface::DEFAULT_TAG, 'route' => 'route_test_5']],
        ],
        [
            'name' => 'Test_SUPER_ADMIN_PARENT',
            'roles' => [RoleInterface::ROLE_SUPER_ADMIN],
            'attributes' => ['test_class' => 'test_logout_super_admin'],
            'route_parameters' => [],
            'tag' => 'test',
            'route' => '',
            'uri' => '#',
            'children' => [['name' => 'Test_SUPER_ADMIN_CHILD', 'roles' => [RoleInterface::ROLE_SUPER_ADMIN], 'attributes' => ['test_class' => 'test_logout_super_admin'], 'route_parameters' => [], 'tag' => 'test', 'route' => 'route_test_6']],
        ],
        [
            'name' => 'Test_USER_PARENT',
            'roles' => [RoleInterface::ROLE_USER],
            'attributes' => ['test_class' => 'test_logout_user'],
            'route_parameters' => [],
            'tag' => 'test',
            'route' => '',
            'uri' => '#',
            'children' => [['name' => 'Test_USER_CHILD', 'roles' => [RoleInterface::ROLE_USER], 'attributes' => ['test_class' => 'test_logout_user'], 'route_parameters' => [], 'tag' => 'test', 'route' => 'route_test_7']],
        ],
    ];

    protected static string $class = BaseMenu::class;

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $referenceName = self::getReferenceName();
        $i = 0;

        $this->entityGenerator($manager, $referenceName, $i, static::$data);

        return $this;
    }

    public static function getGroups(): array
    {
        return [
            FixtureInterface::MENU_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }

    private function entityGenerator(ObjectManager $manager, string $referenceName, int &$i, array $data, $parent = null)
    {
        foreach ($data as $record) {
            /** @var MenuInterface $entity */
            $entity = new static::$class();

            $entity
                ->setName($record['name'])
                ->setRouteParameters($record['route_parameters'])
                ->setAttributes($record['attributes'])
                ->setRoles($record['roles'])
                ->setTag($record['tag']);

            if (null === $parent) {
                $entity->setParent();
            } else {
                $entity->setParent($parent);
            }
            if (\array_key_exists('children', $record)) {
                $entity
                    ->setRoute()
                    ->setUri('#');
                $this->entityGenerator($manager, $referenceName, $i, $record['children'], $entity);
            } else {
                $entity
                    ->setRoute($record['route'])
                    ->setUri();
            }

            $this->addReference($referenceName.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }
    }
}
