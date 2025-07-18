<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\AttributeRepository;

/**
 * Class AttributeController
 * @package App\Http\Controllers\API
 */
class AttributeAPIController extends BaseController
{
    /** @var  AttributeRepository */
    private $attributeRepo;

    /**
     * AttributeAPIController constructor.
     * @param AttributeRepository $attributeRepo
     */
    public function __construct(AttributeRepository $attributeRepo)
    {
        $this->attributeRepo = $attributeRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/attributes",
     *      summary="Get a listing of the Attributes.",
     *      tags={"Attribute"},
     *      description="Get all Attributes",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/definitions/Attribute")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $attributes = $this->attributeRepo->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($attributes->toArray(), 'Atributos requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/attributes",
     *      summary="Store a newly created Attribute in storage",
     *      tags={"Attribute"},
     *      description="Store Attribute",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Attribute")
     *          ),
     *          description="Attribute that should be stored",
     *          required=false
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/definitions/Attribute"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $attribute = $this->attributeRepo->create($input);

        return $this->sendResponse($attribute->toArray(), 'Atributo salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/attributes/{id}",
     *      summary="Display the specified Attribute",
     *      tags={"Attribute"},
     *      description="Get Attribute",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Attribute",
     *          @OA\Schema(
     *             type="integer",
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/definitions/Attribute"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Attribute $attribute */
        $attribute = $this->attributeRepo->find($id);

        if (is_null($attribute)) {
            return $this->sendError('Attribute não encontrado.');
        }

        return $this->sendResponse($attribute->toArray(), 'Atributo requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/attributes/{id}",
     *      summary="Update the specified Attribute in storage",
     *      tags={"Attribute"},
     *      description="Update Attribute",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Attribute",
     *          @OA\Schema(
     *             type="integer",
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Attribute")
     *          ),
     *          description="Attribute that should be updated",
     *          required=false
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/definitions/Attribute"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, Request $request)
    {
        $input = $request->input();

        /** @var Attribute $attribute */
        $attribute = $this->attributeRepo->find($id);

        if (is_null($attribute)) {
            return $this->sendError('Attribute não encontrado.');
        }

        $attribute = $this->attributeRepo->update($input, $id);

        return $this->sendResponse($attribute->toArray(), 'Atributo atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     *
     * @OA\Delete(
     *      path="/attributes/{id}",
     *      summary="Remove the specified Attribute from storage",
     *      tags={"Attribute"},
     *      description="Delete Attribute",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Attribute",
     *          @OA\Schema(
     *             type="integer",
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Attribute $attribute */
        $attribute = $this->attributeRepo->find($id);

        if (is_null($attribute)) {
            return $this->sendError('Atributo não encontrado.');
        }

        $attribute->delete();

        return $this->sendSuccess('Atributo excluído com sucesso.');
    }
}
