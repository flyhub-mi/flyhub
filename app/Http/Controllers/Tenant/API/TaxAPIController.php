<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Tax;
use App\Repositories\Tenant\TaxRateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

/**
 * Class TaxController
 * @package App\Http\Controllers\API
 */

class TaxAPIController extends BaseController
{
    /** @var  taxRateRepository */
    private $taxRateRepository;

    public function __construct(TaxRateRepository $taxRateRepo)
    {
        $this->taxRateRepository = $taxRateRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/taxes",
     *      summary="Get a listing of the Taxs.",
     *      tags={"Tax"},
     *      description="Get all Taxs",
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
     *                  @OA\Items(ref="#/definitions/Tax")
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
        $taxes = $this->taxRateRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($taxes->toArray(), 'Tax Rates requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/taxes",
     *      summary="Store a newly created Tax in storage",
     *      tags={"Tax"},
     *      description="Store Tax",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Tax")
     *          ),
     *          description="Tax that should be stored",
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
     *                  ref="#/definitions/Tax"
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

        $tax = $this->taxRateRepository->create($input);

        return $this->sendResponse($tax->toArray(), 'Tax Rate salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/taxes/{id}",
     *      summary="Display the specified Tax",
     *      tags={"Tax"},
     *      description="Get Tax",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tax",
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
     *                  ref="#/definitions/Tax"
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
        /** @var Tax $tax */
        $tax = $this->taxRateRepository->find($id);

        if (is_null($tax)) {
            return $this->sendError('Tax Rate  não encontrada.');
        }

        return $this->sendResponse($tax->toArray(), 'Tax Rate requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/taxes/{id}",
     *      summary="Update the specified Tax in storage",
     *      tags={"Tax"},
     *      description="Update Tax",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tax",
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
     *              @OA\Schema(ref="#/components/schemas/Tax")
     *          ),
     *          description="Tax that should be updated",
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
     *                  ref="#/definitions/Tax"
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

        /** @var Tax $tax */
        $tax = $this->taxRateRepository->find($id);

        if (is_null($tax)) {
            return $this->sendError('Tax Rate  não encontrada.');
        }

        $tax = $this->taxRateRepository->update($input, $id);

        return $this->sendResponse($tax->toArray(), 'Tax atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/taxes/{id}",
     *      summary="Remove the specified Tax from storage",
     *      tags={"Tax"},
     *      description="Delete Tax",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tax",
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
        /** @var Tax $tax */
        $tax = $this->taxRateRepository->find($id);

        if (is_null($tax)) {
            return $this->sendError('Tax Rate  não encontrada.');
        }

        $tax->delete();

        return $this->sendSuccess('Tax Rate excluído com sucesso.');
    }
}
