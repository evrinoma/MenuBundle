<?php


namespace Evrinoma\MenuBundle\Knp;

use Knp\Menu\Factory\ExtensionInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuFactory;

/**
 * @TODO refactoring MenuFactory
 *
 * Class OverrideMenuFactory
 *
 * @package Evrinoma\MenuBundle\Knp
 */
final class OverrideMenuFactory extends MenuFactory
{
    /**
     * @var array[]
     */
    private $extensions = [];

    /**
     * @var ExtensionInterface[]|null
     */
    private ?ExtensionInterface $sorted = null;

    /**
     * OverrideMenuFactory constructor.
     */
    public function __construct()
    {
       parent::__construct();
    }


    public function createItem(string $name, array $options = []): ItemInterface
    {
        foreach ($this->getExtensions() as $extension) {
            $options = $extension->buildOptions($options);
        }

        $item = new OverrideMenuItem($name, $this);

        foreach ($this->getExtensions() as $extension) {
            $extension->buildItem($item, $options);
        }

        return $item;
    }

    /**
     * Sorts the internal list of extensions by priority.
     *
     * @return ExtensionInterface[]|null
     */
    private function getExtensions(): ?array
    {
        if (null === $this->sorted) {
            \krsort($this->extensions);
            $this->sorted = !empty($this->extensions) ? \call_user_func_array('array_merge', $this->extensions) : [];
        }

        return $this->sorted;
    }

    public function addExtension(ExtensionInterface $extension, int $priority = 0): void
    {
        $this->extensions[$priority][] = $extension;
        $this->sorted = null;
    }
}