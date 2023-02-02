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
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Entity\Menu\BaseMenu;
use Evrinoma\MenuBundle\Model\Menu\MenuInterface;
use Evrinoma\MenuBundle\Registry\ObjectInterface;
use Evrinoma\SecurityBundle\Voter\RoleInterface;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class MenuFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        [
            MenuApiDtoInterface::NAME => 'Test_SUPER_ADMIN',
            MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_SUPER_ADMIN],
            MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_super_admin'],
            MenuApiDtoInterface::ROUTE_PARAMETERS => ['param' => 'value'],
            MenuApiDtoInterface::TAG => ObjectInterface::DEFAULT_TAG,
            MenuApiDtoInterface::ROUTE => 'route_test_0',
        ],
        [
            MenuApiDtoInterface::NAME => 'Test_USER',
            MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_USER],
            MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_user'],
            MenuApiDtoInterface::ROUTE_PARAMETERS => ['param' => 'value'],
            MenuApiDtoInterface::TAG => ObjectInterface::DEFAULT_TAG,
            MenuApiDtoInterface::ROUTE => 'route_test_1',
        ],
        [
            MenuApiDtoInterface::NAME => 'Test_SUPER_ADMIN',
            MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_SUPER_ADMIN],
            MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_super_admin'],
            MenuApiDtoInterface::ROUTE_PARAMETERS => [],
            MenuApiDtoInterface::TAG => 'test',
            MenuApiDtoInterface::ROUTE => 'route_test_2',
        ],
        [
            MenuApiDtoInterface::NAME => 'Test_USER',
            MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_USER],
            MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_user'],
            MenuApiDtoInterface::ROUTE_PARAMETERS => [],
            MenuApiDtoInterface::TAG => 'test',
            MenuApiDtoInterface::ROUTE => 'route_test_3',
        ],
        [
            MenuApiDtoInterface::NAME => 'Test_SUPER_ADMIN_PARENT',
            MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_SUPER_ADMIN],
            MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_super_admin'],
            MenuApiDtoInterface::ROUTE_PARAMETERS => [],
            MenuApiDtoInterface::TAG => ObjectInterface::DEFAULT_TAG,
            MenuApiDtoInterface::ROUTE => '',
            MenuApiDtoInterface::URI => '#',
            MenuApiDtoInterface::CHILD_MENU => [
                [
                    MenuApiDtoInterface::NAME => 'Test_SUPER_ADMIN_CHILD',
                    MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_SUPER_ADMIN],
                    MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_super_admin'],
                    MenuApiDtoInterface::ROUTE_PARAMETERS => ['param' => 'value'],
                    MenuApiDtoInterface::TAG => ObjectInterface::DEFAULT_TAG,
                    MenuApiDtoInterface::ROUTE => 'route_test_4',
                ],
            ],
        ],
        [
            MenuApiDtoInterface::NAME => 'Test_USER_PARENT',
            MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_USER],
            MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_user'],
            MenuApiDtoInterface::ROUTE_PARAMETERS => [],
            MenuApiDtoInterface::TAG => ObjectInterface::DEFAULT_TAG,
            MenuApiDtoInterface::ROUTE => '',
            MenuApiDtoInterface::URI => '#',
            MenuApiDtoInterface::CHILD_MENU => [
                [
                    MenuApiDtoInterface::NAME => 'Test_USER_CHILD',
                    MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_USER],
                    MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_user'],
                    MenuApiDtoInterface::ROUTE_PARAMETERS => ['param' => 'value'],
                    MenuApiDtoInterface::TAG => ObjectInterface::DEFAULT_TAG,
                    MenuApiDtoInterface::ROUTE => 'route_test_5',
                ],
            ],
        ],
        [
            MenuApiDtoInterface::NAME => 'Test_SUPER_ADMIN_PARENT',
            MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_SUPER_ADMIN],
            MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_super_admin'],
            MenuApiDtoInterface::ROUTE_PARAMETERS => [],
            MenuApiDtoInterface::TAG => 'test',
            MenuApiDtoInterface::ROUTE => '',
            MenuApiDtoInterface::URI => '#',
            MenuApiDtoInterface::CHILD_MENU => [
                [
                    MenuApiDtoInterface::NAME => 'Test_SUPER_ADMIN_CHILD',
                    MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_SUPER_ADMIN],
                    MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_super_admin'],
                    MenuApiDtoInterface::ROUTE_PARAMETERS => [],
                    MenuApiDtoInterface::TAG => 'test', MenuApiDtoInterface::ROUTE => 'route_test_6',
                ],
            ],
        ],
        [
            MenuApiDtoInterface::NAME => 'Test_USER_PARENT',
            MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_USER],
            MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_user'],
            MenuApiDtoInterface::ROUTE_PARAMETERS => [],
            MenuApiDtoInterface::TAG => 'test',
            MenuApiDtoInterface::ROUTE => '',
            MenuApiDtoInterface::URI => '#',
            MenuApiDtoInterface::CHILD_MENU => [
                [
                    MenuApiDtoInterface::NAME => 'Test_USER_CHILD',
                    MenuApiDtoInterface::ROLES => [RoleInterface::ROLE_USER],
                    MenuApiDtoInterface::ATTRIBUTES => ['test_class' => 'test_logout_user'],
                    MenuApiDtoInterface::ROUTE_PARAMETERS => [],
                    MenuApiDtoInterface::TAG => 'test',
                    MenuApiDtoInterface::ROUTE => 'route_test_7',
                ],
            ],
        ],
    ];

    protected static string $class = BaseMenu::class;

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

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $referenceName = static::getReferenceName();
        $i = 0;

        $this->entityGenerator($manager, $referenceName, $i, $this->getData());

        return $this;
    }

    private function entityGenerator(ObjectManager $manager, string $referenceName, int &$i, array $data, $parent = null)
    {
        foreach ($data as $record) {
            /** @var MenuInterface $entity */
            $entity = $this->getEntity();

            $entity
                ->setName($record[MenuApiDtoInterface::NAME])
                ->setRouteParameters($record[MenuApiDtoInterface::ROUTE_PARAMETERS])
                ->setAttributes($record[MenuApiDtoInterface::ATTRIBUTES])
                ->setRoles($record[MenuApiDtoInterface::ROLES])
                ->setTag($record[MenuApiDtoInterface::TAG]);

            if (null === $parent) {
                $entity->setParent();
            } else {
                $entity->setParent($parent);
            }
            if (\array_key_exists(MenuApiDtoInterface::CHILD_MENU, $record)) {
                $entity
                    ->setRoute()
                    ->setUri('#');
                $this->entityGenerator($manager, $referenceName, $i, $record[MenuApiDtoInterface::CHILD_MENU], $entity);
            } else {
                $entity
                    ->setRoute($record[MenuApiDtoInterface::ROUTE])
                    ->setUri();
            }

            $this->expandEntity($entity, $record);

            $this->addReference($referenceName.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }
    }
}
