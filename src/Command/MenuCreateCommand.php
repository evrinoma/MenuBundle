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

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\MenuBundle\Exception\MenuCannotBeCreatedException;
use Evrinoma\UtilsBundle\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MenuCreateCommand extends AbstractCommand
{
    protected static $defaultName = 'evrinoma:menu:create';
    protected static $defaultDescription = 'Create a menu.';

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $dto = $this->bridge->argumentToDto($input);
            $this->bridge->action($dto);
            $output->writeln('Created menu');
        } catch (\Exception $e) {
            switch (true) {
                case $e instanceof MenuCannotBeCreatedException:
                    $output->writeln('Menu cannot be save');
                    break;
                case $e instanceof UniqueConstraintViolationException:
                    $output->writeln('Menu already exists');
                    break;
                default:
                    $output->writeln('Something went wrong with user');
            }

            return 1;
        }

        return 0;
    }
}
