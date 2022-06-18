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

namespace Evrinoma\MenuBundle\Command;

use Evrinoma\MenuBundle\Manager\MenuManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class MenuCommand extends Command
{
    protected static $defaultName = 'evrinoma:menu:create';

    private MenuManagerInterface $menuManager;

    public function __construct(MenuManagerInterface $menuManager)
    {
        parent::__construct();
        $this->menuManager = $menuManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName(static::$defaultName)
            ->setDescription('Create default menu')
            ->setHelp(<<<'EOT'
The <info>evrinoma:menu:create</info> command generate default menu

  <info>php %command.full_name%</info>
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->menuManager->create();

        return 0;
    }
}
