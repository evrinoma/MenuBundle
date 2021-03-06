<?php

namespace Evrinoma\MenuBundle\Controller;


use Evrinoma\DtoBundle\Factory\FactoryDto;
use Evrinoma\MenuBundle\Dto\MenuDto;
use Evrinoma\MenuBundle\Manager\MenuManagerInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class MenuApiController
 *
 * @package Evrinoma\MenuBundle\Controller
 */
final class MenuApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var MenuManagerInterface
     */
    private $menuManager;
    /**
     * @var FactoryDto
     */
    private $factoryDto;

    /**
     * @var Request
     */
    private $request;
//endregion Fields

//region SECTION: Constructor
    /**
     * ApiController constructor.
     *
     * @param SerializerInterface  $serializer
     * @param MenuManagerInterface $menuManager
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDto $factoryDto,
        MenuManagerInterface $menuManager
    ) {
        parent::__construct($serializer);
        $this->request     = $requestStack->getCurrentRequest();
        $this->factoryDto  = $factoryDto;
        $this->menuManager = $menuManager;
    }
//endregion Constructor

//region SECTION: Public

    /**
     * @Rest\Get("/api/menu/create", name="api_create_menu")
     * @OA\Get(tags={"menu"})
     * @OA\Response(response=200,description="Returns the rewards of default generated menu")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function menuCreateAction()
    {
        $this->menuManager->create();

        return $this->json(['message' => 'the Menu was generate successFully']);
    }

    /**
     * @Rest\Get("/api/menu/get", name="api_get_menu")
     * @OA\Get(
     *     tags={"menu"}),
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\MenuBundle\Dto\MenuDto",
     *           readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tag",
     *         in="query",
     *         description="tag menu",
     *         required=true,
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\MenuBundle\Form\Rest\TagType::class),
     *              ),
     *          ),
     *         style="form"
     *     ),
     * )
     * @OA\Response(response=200,description="Get menu")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function menuGetAction()
    {
        $menuDto = $this->factoryDto->setRequest($this->request)->createDto(MenuDto::class);

        return $this->setSerializeGroup("api_get_menu")->json($this->menuManager->setRestSuccessOk()->setDto($menuDto)->get()->getData(), $this->menuManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/menu/delete", name="api_delete_menu")
     * @OA\Delete(tags={"menu"})
     * @OA\Response(response=200,description="Returns nothing")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function menuDeleteAction()
    {
        $this->menuManager->delete();

        return $this->json(['message' => 'the Menu was delete successFully']);
    }
//endregion Public
}