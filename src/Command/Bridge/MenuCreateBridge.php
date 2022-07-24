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

use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MenuBundle\Dto\Preserve\MenuApiDtoInterface as PreserveMenuApiDtoInterface;
use Evrinoma\MenuBundle\Manager\CommandManagerInterface;
use Evrinoma\MenuBundle\PreValidator\DtoPreValidator;
use Evrinoma\MenuBundle\Provider\DtoProvider;
use Evrinoma\UtilsBundle\Command\BridgeInterface;
use Symfony\Component\Console\Input\InputInterface;

class MenuCreateBridge implements BridgeInterface
{
    protected static string $dtoClass;

    /**
     * @var DtoPreValidator
     */
    protected DtoPreValidator $preValidator;
    /**
     * @var CommandManagerInterface
     */
    protected CommandManagerInterface $commandManager;
    /**
     * @var ManagerRegistry
     */
    protected ManagerRegistry $managerRegistry;
    /**
     * @var DtoProvider
     */
    private DtoProvider       $provider;

    /**
     * @param ManagerRegistry         $managerRegistry
     * @param CommandManagerInterface $commandManager
     * @param DtoPreValidator         $preValidator
     * @param DtoProvider             $provider
     * @param string                  $dtoClass
     */
    public function __construct(ManagerRegistry $managerRegistry, CommandManagerInterface $commandManager, DtoPreValidator $preValidator, DtoProvider $provider, string $dtoClass)
    {
        $this->managerRegistry = $managerRegistry;
        $this->commandManager = $commandManager;
        $this->preValidator = $preValidator;
        $this->provider = $provider;
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
        $commandManager = $this->commandManager;

        $em = $this->managerRegistry->getManager();

        $connection = $em->getConnection();
        try {
            $connection->beginTransaction();
            foreach ($this->provider->toDto()->getReverse() as $item) {
                $this->preValidator->onPost($item);
                $menuItem = $commandManager->post($item);
                $em->flush();
                $item->setId($menuItem->getId());
            }
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
        }
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
