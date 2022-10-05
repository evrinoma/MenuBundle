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

namespace Evrinoma\MenuBundle\Command\Bridge;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MenuBundle\Dto\Preserve\MenuApiDtoInterface as PreserveMenuApiDtoInterface;
use Evrinoma\MenuBundle\Facade\Menu\FacadeInterface;
use Evrinoma\UtilsBundle\Command\BridgeInterface;
use Symfony\Component\Console\Input\InputInterface;

class MenuCreateBridge implements BridgeInterface
{
    protected static string $dtoClass;

    private FacadeInterface $facade;

    /**
     * @param FacadeInterface $facade
     * @param string          $dtoClass
     */
    public function __construct(FacadeInterface $facade, string $dtoClass)
    {
        $this->facade = $facade;
        static::$dtoClass = $dtoClass;
    }

    public function argumentDefinition(): array
    {
        return [];
    }

    public function helpMessage(): string
    {
        return <<<'EOT'
The <info>evrinoma:menu:create</info> command creates a menu:
  <info>php %command.full_name%</info>
EOT;
    }

    public function action(DtoInterface $dto): void
    {
        $data = [];

        $this->facade->registry('', $data);
    }

    public function argumentQuestioners(InputInterface $input): array
    {
        return [];
    }

    public function optionQuestioners(InputInterface $input): array
    {
        return [];
    }

    public function argumentToDto(InputInterface $input): DtoInterface
    {
        /* @var PreserveMenuApiDtoInterface $dto */
        return new static::$dtoClass();
    }
}
