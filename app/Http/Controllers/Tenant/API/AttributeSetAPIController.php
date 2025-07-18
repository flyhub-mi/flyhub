<?php

namespace App\Http\Controllers\Tenant\API;

use App\Http\Controllers\BaseController;
use App\Models\Tenant\AttributeSet;
use App\Repositories\Tenant\AttributeSetRepository;
use Illuminate\Http\Request;

/**
 * Class AttributeSetController
 * @package App\Http\Controllers\API
 */
class AttributeSetAPIController extends BaseController
{
    /** @var  AttributeSetRepository */
    private $attributeSetRepository;

    /**
     * AttributeSetAPIController constructor.
     * @param AttributeSetRepository $attributeSetRepo
     */
    public function __construct(AttributeSetRepository $attributeSetRepo)
    {
        $this->attributeSetRepository = $attributeSetRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/attribute-sets",
     *      summary="Get a listing of the AttributeSets.",
     *      tags={"AttributeSet"},
     *      description="Get all AttributeSets",
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
     *                  @OA\Items(ref="#/definitions/AttributeSet")
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
        $attributeSets = $this->attributeSetRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($attributeSets->toArray(), 'Conjunto de Atributos requisitada com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/attribute-sets",
     *      summary="Store a newly created AttributeSet in storage",
     *      tags={"AttributeSet"},
     *      description="Store AttributeSet",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/AttributeSet")
     *          ),
     *          description="AttributeSet that should be stored",
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
     *                  ref="#/definitions/AttributeSet"
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
        $attributeSet = $this->attributeSetRepository->create($input);

        return $this->sendResponse($attributeSet->toArray(), 'Conjunto de Atributos salva com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/attribute-sets/{id}",
     *      summary="Display the specified AttributeSet",
     *      tags={"AttributeSet"},
     *      description="Get AttributeSet",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of AttributeSet",
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
     *                  ref="#/definitions/AttributeSet"
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
        /** @var AttributeSet $attributeSet */
        $attributeSet = $this->attributeSetRepository->find($id);

        if (is_null($attributeSet)) {
            return $this->sendError('Conjunto de Atributos não encontrada.');
        }

        return $this->sendResponse($attributeSet->toArray(), 'Conjunto de Atributos requisitada com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/attribute-sets/{id}",
     *      summary="Update the specified AttributeSet in storage",
     *      tags={"AttributeSet"},
     *      description="Update AttributeSet",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of AttributeSet",
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
     *              @OA\Schema(ref="#/components/schemas/AttributeSet")
     *          ),
     *          description="AttributeSet that should be updated",
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
     *                  ref="#/definitions/AttributeSet"
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

        /** @var AttributeSet $attributeSet */
        $attributeSet = $this->attributeSetRepository->find($id);

        if (is_null($attributeSet)) {
            return $this->sendError('Attribute Set   não encontrada.');
        }

        $attributeSet = $this->attributeSetRepository->update($input, $id);

        return $this->sendResponse($attributeSet->toArray(), 'Conjunto de Atributos atualizada.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     *
     * @OA\Delete(
     *      path="/attribute-sets/{id}",
     *      summary="Remove the specified AttributeSet from storage",
     *      tags={"AttributeSet"},
     *      description="Delete AttributeSet",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of AttributeSet",
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
        /** @var AttributeSet $attributeSet */
        $attributeSet = $this->attributeSetRepository->find($id);

        if (is_null($attributeSet)) {
            return $this->sendError('Conjunto de Atributos não encontrada.');
        }

        if (count($attributeSet->attributes) > 0) {
            return $this->sendError('Não é possível excluir conjunto com atributos relacionados.');
        }

        $attributeSet->delete();

        return $this->sendSuccess('Conjunto de Atributos excluída com sucesso.');
    }
}
