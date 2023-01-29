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

namespace Evrinoma\MenuBundle\Form\Rest;

use Doctrine\DBAL\Exception\TableNotFoundException;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuTagNotFoundException;
use Evrinoma\MenuBundle\Manager\QueryManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuTagChoiceType extends AbstractType
{
    protected static string $dtoClass;

    private QueryManagerInterface $queryManager;

    public function __construct(QueryManagerInterface $queryManager, string $dtoClass)
    {
        $this->queryManager = $queryManager;
        static::$dtoClass = $dtoClass;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $value = [];
            try {
                if ($options->offsetExists('data')) {
                    switch ($options->offsetGet('data')) {
                        case MenuApiDtoInterface::TAG:
                            $value = $this->queryManager->tags(new static::$dtoClass());
                            break;
                        default:
                            $criteria = $this->queryManager->criteria(new static::$dtoClass());
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getId();
                            }
                    }
                } else {
                    throw new MenuTagNotFoundException();
                }
            } catch (TableNotFoundException|MenuTagNotFoundException $e) {
                $value = RestChoiceType::REST_CHOICES_DEFAULT;
            }

            return $value;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'tag');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'tagList');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }

    public function getParent()
    {
        return RestChoiceType::class;
    }
}
