<?php

namespace Evrinoma\MenuBundle\Form\Rest;

use Evrinoma\DtoBundle\Factory\FactoryDto;
use Evrinoma\MenuBundle\Dto\MenuDto;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Manager\MenuManagerInterface;

use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MenuTagType
 *
 * @package Evrinoma\MenuBundle\Form\Rest
 */
class MenuTagChoiceType extends AbstractType
{

    /**
     * @var MenuManagerInterface
     */
    private MenuManagerInterface $menuManager;




    /**
     * ServerType constructor.
     */
    public function __construct(MenuManagerInterface $menuManager)
    {
        $this->menuManager = $menuManager;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            return $this->menuManager->getTags();
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