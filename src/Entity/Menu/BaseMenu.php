<?php
namespace Evrinoma\MenuBundle\Entity\Menu;

use Evrinoma\MenuBundle\Model\Menu\AbstractMenuItem;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="menu_items")
*/
class BaseMenu extends AbstractMenuItem
{
}