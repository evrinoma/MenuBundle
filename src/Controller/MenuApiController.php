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

namespace Evrinoma\MenuBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\MenuBundle\Dto\MenuApiDtoInterface;
use Evrinoma\MenuBundle\Exception\MenuCannotBeSavedException;
use Evrinoma\MenuBundle\Exception\MenuInvalidException;
use Evrinoma\MenuBundle\Exception\MenuNotFoundException;
use Evrinoma\MenuBundle\Facade\Menu\FacadeInterface;
use Evrinoma\MenuBundle\Serializer\GroupInterface;
use Evrinoma\UtilsBundle\Controller\AbstractWrappedApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\UtilsBundle\Serialize\SerializerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class MenuApiController extends AbstractWrappedApiController implements ApiControllerInterface
{
    private string $dtoClass;

    private ?Request $request;

    private FactoryDtoInterface $factoryDto;

    private FacadeInterface $facade;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        FacadeInterface $facade,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->dtoClass = $dtoClass;
        $this->facade = $facade;
    }

    /**
     * @param \Exception $e
     *
     * @return array
     */
    public function setRestStatus(\Exception $e): array
    {
        switch (true) {
            case $e instanceof MenuCannotBeSavedException:
                $this->setStatusNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $this->setStatusConflict();
                break;
            case $e instanceof MenuNotFoundException:
                $this->setStatusNotFound();
                break;
            case $e instanceof MenuInvalidException:
                $this->setStatusUnprocessableEntity();
                break;
            default:
                $this->setStatusBadRequest();
        }

        return [$e->getMessage()];
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
     *                     "name": "Service",
     *                     "roles": {"A", "B", "C"},
     *                     "route": "core_home",
     *                     "uri": "#",
     *                     "attributes": {"D": "d", "E": "e", "F": "f"},
     *                     "route_parameters": {"alias", "cam"},
     *                     "child_menu": {
     *                         {"id": "1"},
     *                         {"id": "2"},
     *                     },
     *                     "tag": "default",
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\MenuBundle\Dto\MenuApiDto"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="route", type="string"),
     *                 @OA\Property(property="roles", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="attributes", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="route_parameters", type="array", @OA\Items(type="string")),
     *                 @OA\Property(
     *                     property="child_menu",
     *                     type="array",
     *                     @OA\Items(type="object", @OA\Property(property="id", type="string", example="2"))
     *                 ),
     *                 @OA\Property(property="tag", type="string")
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

        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_MENU;

        try {
            $this->facade->post($menuApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create menu', $json, $error);
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
     *                     "id": "3",
     *                     "name": "Service",
     *                     "roles": {"A", "B", "C"},
     *                     "route": "core_home",
     *                     "uri": "#",
     *                     "attributes": {"D": "d", "E": "e", "F": "f"},
     *                     "route_parameters": {"alias", "cam"},
     *                     "child_menu": {
     *                         {"id": "1"},
     *                         {"id": "2"},
     *                     },
     *                     "tag": "default",
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\MenuBundle\Dto\MenuApiDto"),
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="route", type="string"),
     *                 @OA\Property(property="roles", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="attributes", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="route_parameters", type="array", @OA\Items(type="string")),
     *                 @OA\Property(
     *                     property="child_menu",
     *                     type="array",
     *                     @OA\Items(type="object", @OA\Property(property="id", type="string", example="2"))
     *                 ),
     *                 @OA\Property(property="tag", type="string")
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

        $json = [];
        $error = [];
        $group = GroupInterface::API_PUT_MENU;

        try {
            $this->facade->put($menuApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Save menu', $json, $error);
    }

    /**
     * @Rest\Delete("/api/menu/delete", options={"expose": true}, name="api_delete_menu")
     * @OA\Delete(
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
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Delete menu")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var MenuApiDtoInterface $menuApiDto */
        $menuApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->delete($menuApiDto, '', $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Delete menu', $json, $error);
    }

    /**
     * @Rest\Delete("/api/menu/remove", options={"expose": true}, name="api_remove_menu")
     * @OA\Delete(
     *     tags={"menu"}
     * )
     * @OA\Response(response=200, description="Remove all menu items")
     *
     * @return JsonResponse
     */
    public function removeAction(): JsonResponse
    {
        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->remove(new $this->dtoClass(), '', $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Remove all items', $json, $error);
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
     *     ),
     *     @OA\Parameter(
     *         description="route",
     *         in="query",
     *         name="route",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="name",
     *         in="query",
     *         name="name",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="root Level",
     *         in="query",
     *         name="root",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tag",
     *         in="query",
     *         description="tag menu",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 ref=@Model(type=Evrinoma\MenuBundle\Form\Rest\MenuTagChoiceType::class, options={"data": "tag"}),
     *             ),
     *         ),
     *         style="form"
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

        $json = [];
        $error = [];
        $group = GroupInterface::API_CRITERIA_MENU;

        try {
            $this->facade->criteria($menuApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get menu', $json, $error);
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

        $json = [];
        $error = [];
        $group = GroupInterface::API_GET_MENU;

        try {
            $this->facade->get($menuApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get menu', $json, $error);
    }

    /**
     * @Rest\Post("/api/menu/registry/create", name="api_registry_create_menu")
     * @OA\Post(tags={"menu"})
     * @OA\Response(response=200, description="Returns the rewards of default generated menu")
     *
     * @return JsonResponse
     */
    public function registryAction(): JsonResponse
    {
        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_REGISTRY_MENU;

        try {
            $this->facade->registry($group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create menu from registry', $json, $error);
    }
}
