<?php

namespace Evrinoma\MenuBundle\Manager;

use Evrinoma\LiveVideoBundle\Voter\LiveVideoRoleInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Voter\RoleInterface;
use Evrinoma\UtilsBundle\Voter\VoterInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

/**
 * Class MenuManager
 *
 * @package App\Manager
 */
class MenuManager extends AbstractEntityManager
{
//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = MenuItem::class;
    /**
     * @var VoterInterface
     */
    private $voterManager;
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var MenuInterface[]
     */
    private $menuItems = [];
//endregion Fields

//region SECTION: Constructor
    /**
     * MenuManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param FactoryInterface       $factory
     * @param VoterInterface           $voterManager
     */
    public function __construct(EntityManagerInterface $entityManager, FactoryInterface $factory, VoterInterface $voterManager)
    {
        parent::__construct($entityManager);
        $this->factory      = $factory;
        $this->voterManager = $voterManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param array $options
     *
     * @return ItemInterface
     */
    public function createMainMenu(array $options)
    {
        $root = $this->factory->createItem('root');

        $items = $this->getMenuItems($root);

        $this->createMenu($root, $items);

        return $root;
    }

    public function deleteDefaultMenu(): void
    {
        $allMenuItems = $this->repository->findAll();
        foreach ($allMenuItems as $menu) {
            $this->entityManager->remove($menu);
        }
        $this->entityManager->flush();
    }


    public function addMenuIte(MenuInterface $item):void
    {
        if (!array_key_exists($item->order(),$this->menuItems)) {
            $this->menuItems[$item->order()] = $item;
        } else {
            throw new \Exception('MenuItem '.get_class($item).'override another MenuItem');
        }
    }

    public function createDefaultMenu(): void
    {
        if (count($this->menuItems)) {
            ksort($this->menuItems);
            foreach ($this->menuItems as $item) {
                $item->createMenu($this->entityManager);
            }
           $this->entityManager->flush();
        }
    }
//endregion Public

//region SECTION: Private
    /**
     * @param ItemInterface $menuLevel
     * @param MenuItem      $menuItem
     *
     * @return mixed
     */
    private function createItem($menuLevel, $menuItem)
    {
        return $menuLevel->addChild($menuItem->getName(), $menuItem->getOptions());
    }

    /**
     * @param MenuItem[] $items
     */
    private function createMenu($menu, array $items)
    {
        foreach ($items as $menuItem) {
            if ($this->voterManager->checkPermission($menuItem->getRole())) {
                if ($menuItem->hasChildren()) {
                    $menuLevel = $this->createItem($menu, $menuItem);
                    $this->createMenu($menuLevel, $menuItem->getChildren()->getValues());
                } else {
                    $this->createItem($menu, $menuItem);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    private function getMenuItems()
    {
        return $this->repository->findBy(['parent' => null]);
    }
//endregion Private
}