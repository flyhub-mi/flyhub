<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Refund;
use App\Repositories\Tenant\RefundRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class RefundController
 * @package App\Http\Controllers\API
 */

class RefundAPIController extends BaseController
{
    /** @var  RefundRepository */
    private $refundRepository;

    public function __construct(RefundRepository $refundRepo)
    {
        $this->refundRepository = $refundRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/refunds",
     *      summary="Get a listing of the Refunds.",
     *      tags={"Refund"},
     *      description="Get all Refunds",
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
     *                  @OA\Items(ref="#/definitions/Refund")
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
        $refunds = $this->refundRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($refunds->toArray(), 'Refunds requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/refunds",
     *      summary="Store a newly created Refund in storage",
     *      tags={"Refund"},
     *      description="Store Refund",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Refund")
     *          ),
     *          description="Refund that should be stored",
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
     *                  ref="#/definitions/Refund"
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

        $refund = $this->refundRepository->create($input);

        return $this->sendResponse($refund->toArray(), 'Refund salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/refunds/{id}",
     *      summary="Display the specified Refund",
     *      tags={"Refund"},
     *      description="Get Refund",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Refund",
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
     *                  ref="#/definitions/Refund"
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
        /** @var Refund $refund */
        $refund = $this->refundRepository->find($id);

        if (is_null($refund)) {
            return $this->sendError('Refund  não encontrada.');
        }

        return $this->sendResponse($refund->toArray(), 'Refund requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/refunds/{id}",
     *      summary="Update the specified Refund in storage",
     *      tags={"Refund"},
     *      description="Update Refund",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Refund",
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
     *              @OA\Schema(ref="#/components/schemas/Refund")
     *          ),
     *          description="Refund that should be updated",
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
     *                  ref="#/definitions/Refund"
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

        /** @var Refund $refund */
        $refund = $this->refundRepository->find($id);

        if (is_null($refund)) {
            return $this->sendError('Refund  não encontrada.');
        }

        $refund = $this->refundRepository->update($input, $id);

        return $this->sendResponse($refund->toArray(), 'Reembolso atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/refunds/{id}",
     *      summary="Remove the specified Refund from storage",
     *      tags={"Refund"},
     *      description="Delete Refund",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Refund",
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
        /** @var Refund $refund */
        $refund = $this->refundRepository->find($id);

        if (is_null($refund)) {
            return $this->sendError('Refund  não encontrada.');
        }

        $refund->delete();

        return $this->sendSuccess('Refund excluído com sucesso.');
    }
}
