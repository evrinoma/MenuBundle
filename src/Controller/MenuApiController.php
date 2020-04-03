<?php

namespace Evrinoma\MenuBundle\Controller;


use Evrinoma\MenuBundle\Manager\MenuManager;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Swagger\Annotations as SWG;

/**
 * Class MenuApiController
 *
 * @package Evrinoma\MenuBundle\Controller
 */
final class MenuApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var MenuManager
     */
    private $menuManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ApiController constructor.
     *
     * @param SerializerInterface $serializer
     * @param MenuManager         $menuManager
     */
    public function __construct(
        SerializerInterface $serializer,
        MenuManager $menuManager
    ) {
        parent::__construct($serializer);
        $this->menuManager = $menuManager;
    }
//endregion Constructor

//region SECTION: Public

    /**
     * @Rest\Get("/api/menu/create_default", name="api_create_default_menu")
     * @SWG\Get(tags={"menu"})
     * @SWG\Response(response=200,description="Returns the rewards of default generated menu")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function menuCreateDefaultAction()
    {
        $this->menuManager->createDefaultMenu();

        return $this->json(['message' => 'the Menu was generate successFully']);
    }

    /**
     * @Rest\Delete("/api/menu/delete", name="api_delete_menu")
     * @SWG\Delete(tags={"menu"})
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function menuDeleteAction()
    {
        $this->menuManager->deleteDefaultMenu();

        return $this->json(['message' => 'the Menu was delete successFully']);
    }
//endregion Public
}