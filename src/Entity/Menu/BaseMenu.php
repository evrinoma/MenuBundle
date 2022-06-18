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

namespace Evrinoma\MenuBundle\Entity\Menu;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\MenuBundle\Model\Menu\AbstractMenuItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="menu_items")
 */
class BaseMenu extends AbstractMenuItem
{
}
