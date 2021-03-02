<?php

namespace Evrinoma\MenuBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Evrinoma\MenuBundle\Dto\MenuDto;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Menu\MenuInterface;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Voter\VoterInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

/**
 * Class MenuManager
 *
 * @package App\Manager
 */
class MenuManager extends AbstractEntityManager implements MenuManagerInterface
{
    use RestTrait;

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

    /**
     * @var MenuDto
     */
    private $dto;
//endregion Fields

//region SECTION: Constructor
    /**
     * MenuManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param FactoryInterface       $factory
     * @param VoterInterface         $voterManager
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
     * @param mixed $options
     *
     * @return ItemInterface
     */
    public function createMainMenu($options)
    {
        $this->toDto($options);

        $root = $this->factory->createItem('root');

        $items = $this->findMenuItems();

        $this->createMenu($root, $items);

        return $root;
    }

    public function delete(): void
    {
        $allMenuItems = $this->repository->findAll();
        foreach ($allMenuItems as $menu) {
            $this->entityManager->remove($menu);
        }
        $this->entityManager->flush();
    }


    public function addMenuItem(MenuInterface $item): void
    {
        if (!array_key_exists($item->order(), $this->menuItems)) {
            $this->menuItems[$item->tag()][$item->order()] = $item;
        } else {
            throw new \Exception('MenuItem '.get_class($item).'override another MenuItem');
        }
    }

    public function create(): void
    {
        if (count($this->menuItems)) {
            foreach ($this->menuItems as $tag) {
                if (count($tag)) {
                    ksort($tag);
                    foreach ($tag as $item) {
                        $item->create($this->entityManager);
                    }
                }
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
    private function findTagItems()
    {
        $query = $this->repository
            ->createQueryBuilder("menu")
            ->select("menu.tag")
            ->groupBy("menu.tag");

        return array_column($query->getQuery()->getResult(), 'tag');
    }

    /**
     * @return mixed
     */
    private function findMenuItems()
    {
        $query = $this->repository
            ->createQueryBuilder("menu")
            ->select("menu, children")
            ->leftJoin('menu.children', 'children')
            ->where('menu.parent is NULL');

        if ($this->dto->hasTag()) {
            $query->andWhere("menu.tag = :tag AND children.tag = :tag")
                ->setParameter("tag", $this->dto->getTag());
        }

        return $query->getQuery()
            ->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true)
            ->getResult();
    }
//endregion Private

//region SECTION: Dto
    public function setDto($dto): MenuManagerInterface
    {
        $this->dto = $dto;

        return $this;
    }

    private function toDto($options): void
    {
        if ($this->dto === null) {
            $this->dto = new MenuDto();
        }

        if ($options && !($options instanceof MenuDto)) {
            $this->dto->setTag(array_key_exists('tag', $options) ? $options['tag'] : null);
        }
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    public function get($options = []): MenuManagerInterface
    {
        $this->setData($this->createMainMenu($options));

        return $this;
    }

    public function getTags(): array
    {
        return $this->findTagItems();
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}