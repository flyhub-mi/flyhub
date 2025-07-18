<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\TaxGroup;
use App\Repositories\Tenant\TaxGroupRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

/**
 * Class TaxGroupController
 * @package App\Http\Controllers\API
 */

class TaxGroupAPIController extends BaseController
{
    /** @var  taxGroupRepository */
    private $taxGroupRepository;

    public function __construct(TaxGroupRepository $taxGroupRepo)
    {
        $this->taxGroupRepository = $taxGroupRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/tax-groups",
     *      summary="Get a listing of the TaxGroups.",
     *      tags={"TaxGroup"},
     *      description="Get all TaxGroups",
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
     *                  @OA\Items(ref="#/definitions/TaxGroup")
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
        $taxGroup = $this->taxGroupRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($taxGroup->toArray(), 'Tax Group requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/tax-groups",
     *      summary="Store a newly created TaxGroup in storage",
     *      tags={"TaxGroup"},
     *      description="Store TaxGroup",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/TaxGroup")
     *          ),
     *          description="TaxGroup that should be stored",
     *          required=false,
     *
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
     *                  ref="#/definitions/TaxGroup"
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

        $taxGroup = $this->taxGroupRepository->create($input);

        return $this->sendResponse($taxGroup->toArray(), 'Tax Group salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/tax-groups/{id}",
     *      summary="Display the specified TaxGroup",
     *      tags={"TaxGroup"},
     *      description="Get TaxGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TaxGroup",
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
     *                  ref="#/definitions/TaxGroup"
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
        /** @var TaxGroup $taxGroup */
        $taxGroup = $this->taxGroupRepository->find($id);

        if (is_null($taxGroup)) {
            return $this->sendError('Tax Group não encontrado.');
        }

        return $this->sendResponse($taxGroup->toArray(), 'Tax Group requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/tax-groups/{id}",
     *      summary="Update the specified TaxGroup in storage",
     *      tags={"TaxGroup"},
     *      description="Update TaxGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TaxGroup",
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
     *              @OA\Schema(ref="#/components/schemas/TaxGroup")
     *          ),
     *          description="TaxGroup that should be updated",
     *          required=false,
     *
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
     *                  ref="#/definitions/TaxGroup"
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

        /** @var TaxGroup $taxGroup */
        $taxGroup = $this->taxGroupRepository->find($id);

        if (is_null($taxGroup)) {
            return $this->sendError('Tax Group não encontrado.');
        }

        $taxGroup = $this->taxGroupRepository->update($input, $id);

        return $this->sendResponse($taxGroup->toArray(), 'TaxGroup atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/tax-groups/{id}",
     *      summary="Remove the specified TaxGroup from storage",
     *      tags={"TaxGroup"},
     *      description="Delete TaxGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TaxGroup",
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
        /** @var TaxGroup $taxGroup */
        $taxGroup = $this->taxGroupRepository->find($id);

        if (is_null($taxGroup)) {
            return $this->sendError('Tax Group não encontrado.');
        }

        $taxGroup->delete();

        return $this->sendSuccess('Tax Group excluído com sucesso.');
    }
}
