<?php

namespace Evrinoma\MenuBundle\Knp;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuItem;
use JMS\Serializer\Annotation as JMS;

/**
 * Class OverrideMenuItem
 *
 * @package Evrinoma\MenuBundle\Knp
 */
final class OverrideMenuItem extends MenuItem
{
    /**
     * Name of this menu item (used for id by parent menu)
     *
     * @var string
     * @JMS\Type("string")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $name;

    /**
     * Label to output, name is used by default
     *
     * @var string|null
     * @JMS\Type("string")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $label;

    /**
     * Attributes for the item link
     *
     * @var array
     * @JMS\Type("array")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $linkAttributes = [];

    /**
     * Attributes for the children list
     *
     * @var array
     * @JMS\Type("array")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $childrenAttributes = [];

    /**
     * Attributes for the item text
     *
     * @var array
     * @JMS\Type("array")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $labelAttributes = [];

    /**
     * Uri to use in the anchor tag
     *
     * @var string|null
     * @JMS\Type("string")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $uri;

    /**
     * Attributes for the item
     *
     * @var array
     * @JMS\Type("array")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $attributes = [];

    /**
     * Extra stuff associated to the item
     *
     * @var array
     * @JMS\Type("array")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $extras = [];

    /**
     * Whether the item is displayed
     *
     * @var bool
     * @JMS\Type("bool")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $display = true;

    /**
     * Whether the children of the item are displayed
     *
     * @var bool
     * @JMS\Type("bool")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $displayChildren = true;

    /**
     * Child items
     *
     * @var ItemInterface[]
     * @JMS\Type("array<Evrinoma\MenuBundle\Knp\OverrideMenuItem>")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $children = [];

    /**
     * Parent item
     *
     * @var ItemInterface|null
     * @JMS\Type("Evrinoma\MenuBundle\Knp\OverrideMenuItem")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $parent;

    /**
     * whether the item is current. null means unknown
     *
     * @var bool|null
     * @JMS\Type("bool")
     * @JMS\Groups({"api_get_menu"})
     */
    protected $isCurrent;

    /**
     * @var FactoryInterface
     * @JMS\Expose
     */
    protected $factory;
}
