<?php

namespace Evrinoma\MenuBundle\Controller;


use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDto;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Dto\MenuDto;
use Evrinoma\MenuBundle\Exception\MenuCannotBeSavedException;
use Evrinoma\MenuBundle\Exception\MenuInvalidException;
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Manager\CommandManagerInterface;
use Evrinoma\MenuBundle\Manager\MenuManagerInterface;
use Evrinoma\MenuBundle\Manager\QueryManagerInterface;
use Evrinoma\MenuBundle\PreValidator\DtoPreValidatorInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class MenuApiController
 *
 * @package Evrinoma\MenuBundle\Controller
 */
final class MenuApiController extends AbstractApiController implements ApiControllerInterface
{
    private string $dtoClass = MenuDto::class;
//    /**
//     * @var MenuManagerInterface
//     */
//    private MenuManagerInterface $menuManager;
    /**
     * @var ?Request
     */
    private ?Request $request;
    /**
     * @var QueryManagerInterface|RestInterface
     */
    private QueryManagerInterface $queryManager;
    /**
     * @var CommandManagerInterface|RestInterface
     */
    private CommandManagerInterface $commandManager;
    /**
     * @var FactoryDtoInterface
     */
    private FactoryDtoInterface $factoryDto;
    /**
     * @var DtoPreValidatorInterface
     */
    private DtoPreValidatorInterface $preValidator;




    /**
     * @param SerializerInterface      $serializer
     * @param RequestStack             $requestStack
     * @param FactoryDtoInterface      $factoryDto
     * @param CommandManagerInterface  $commandManager
     * @param QueryManagerInterface    $queryManager
     * @param DtoPreValidatorInterface $preValidator
     */
    public function __construct(
SerializerInterface $serializer,
RequestStack $requestStack,
FactoryDtoInterface $factoryDto,
CommandManagerInterface $commandManager,
QueryManagerInterface $queryManager,
DtoPreValidatorInterface $preValidator
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->commandManager = $commandManager;
        $this->queryManager = $queryManager;
        $this->preValidator = $preValidator;
    }




//    /**
//     * @Rest\Get("/api/menu/create", name="api_create_menu")
//     * @OA\Get(tags={"menu"})
//     * @OA\Response(response=200,description="Returns the rewards of default generated menu")
//     *
//     * @return \Symfony\Component\HttpFoundation\JsonResponse
//     */
//    public function menuCreateAction()
//    {
//        $this->menuManager->create();
//
//        return $this->json(['message' => 'the Menu was generate successFully']);
//    }
//
//    /**
//     * @Rest\Get("/api/menu/get", name="api_get_menu")
//     * @OA\Get(
//     *     tags={"menu"}),
//     *     @OA\Parameter(
//     *         description="class",
//     *         in="query",
//     *         name="class",
//     *         required=true,
//     *         @OA\Schema(
//     *           type="string",
//     *           default="Evrinoma\MenuBundle\Dto\MenuDto",
//     *           readOnly=true
//     *         )
//     *     ),
//     *     @OA\Parameter(
//     *         name="tag",
//     *         in="query",
//     *         description="tag menu",
//     *         required=true,
//     *         @OA\Schema(
//     *              type="array",
//     *              @OA\Items(
//     *                  type="string",
//     *                  ref=@Model(type=Evrinoma\MenuBundle\Form\Rest\MenuTagChoiceType::class),
//     *              ),
//     *          ),
//     *         style="form"
//     *     ),
//     * )
//     * @OA\Response(response=200,description="Get menu")
//     *
//     * @return \Symfony\Component\HttpFoundation\JsonResponse
//     */
//    public function menuGetAction()
//    {
//        $menuDto = $this->factoryDto->setRequest($this->request)->createDto(MenuDto::class);
//
//        return $this->setSerializeGroup("api_get_menu")->json($this->menuManager->setRestOk()->setDto($menuDto)->get()->getData(), $this->menuManager->getRestStatus());
//
//        try {
//            $json = $this->queryManager->get($menuDto);
//        } catch (\Exception $e) {
//            $json = $this->setRestStatus($this->queryManager, $e);
//        }
//
//        return $this->setSerializeGroup('api_get_menu')->json(['message' => 'Get project', 'data' => $json], $this->queryManager->getRestStatus());
//    }
//
//    /**
//     * @Rest\Delete("/api/menu/delete", name="api_delete_menu")
//     * @OA\Delete(tags={"menu"})
//     * @OA\Response(response=200,description="Returns nothing")
//     *
//     * @return \Symfony\Component\HttpFoundation\JsonResponse
//     */
//    public function menuDeleteAction()
//    {
//        $this->menuManager->delete();
//
//        return $this->json(['message' => 'the Menu was delete successFully']);
//    }


    /**
     * @param RestInterface $manager
     * @param \Exception    $e
     *
     * @return array
     */
    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof MenuCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof MenuNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof MenuInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }

    /**
     * @Rest\Post("/api/menu/create", options={"expose": true}, name="api_menu_create")
     * @OA\Post(
     *     tags={"menu"},
     *     description="the method perform create menu",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\MenuBundle\Dto\MenuApiDto",
     *                     "id": "1"
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\MenuBundle\Dto\MenuApiDto"),
     *                 @OA\Property(property="id", type="string")
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Create menu")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var MenuApiDtoInterface $menuApiDto */
        $menuApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        $this->commandManager->setRestCreated();
        try {
            $this->preValidator->onPost($menuApiDto);

            $json = [];
            $em = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($menuApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($menuApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_menu')->json(['message' => 'Create menu', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/menu/save", options={"expose": true}, name="api_menu_save")
     * @OA\Put(
     *     tags={"menu"},
     *     description="the method perform save menu for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\MenuBundle\Dto\MenuApiDto",
     *                     "id": "1"
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\MenuBundle\Dto\MenuApiDto"),
     *                 @OA\Property(property="id", type="string")
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Save menu")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var MenuApiDtoInterface $fcrApiDto */
        $menuApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        try {
            $this->preValidator->onPut($menuApiDto);

            $json = [];
            $em = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($menuApiDto, $commandManager, &$json) {
                    $json = $commandManager->put($menuApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_menu')->json(['message' => 'Save menu', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/menu/delete", options={"expose": true}, name="api_delete_menu")
     * @OA\Delete(tags={"menu"})
     * @OA\Response(response=200, description="Delete menu")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var MenuApiDtoInterface $menuApiDto */
        $menuApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $commandManager = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            $this->preValidator->onDelete($menuApiDto);
            $json = [];
            $em = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($menuApiDto, $commandManager, &$json) {
                    $commandManager->delete($menuApiDto);
                    $json = ['OK'];
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete menu', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/menu/criteria", options={"expose": true}, name="api_menu_criteria")
     * @OA\Get(
     *     tags={"menu"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\MenuBundle\Dto\MenuApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return menu")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var MenuApiDtoInterface $menuApiDto */
        $menuApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($menuApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_menu')->json(['message' => 'Get menu', 'data' => $json], $this->queryManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/menu", options={"expose": true}, name="api_menu")
     * @OA\Get(
     *     tags={"menu"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\MenuBundle\Dto\MenuApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="1",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return menu")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var MenuApiDtoInterface $menuApiDto */
        $menuApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($menuApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_menu')->json(['message' => 'Get menu', 'data' => $json], $this->queryManager->getRestStatus());
    }
}