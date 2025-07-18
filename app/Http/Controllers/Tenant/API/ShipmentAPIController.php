<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Shipment;
use App\Repositories\Tenant\ShipmentRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;


/**
 * Class ShipmentController
 * @package App\Http\Controllers\API
 */

class ShipmentAPIController extends BaseController
{
    /** @var  ShipmentRepository */
    private $shipmentRepository;

    public function __construct(ShipmentRepository $shipmentRepo)
    {
        $this->shipmentRepository = $shipmentRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/shipments",
     *      summary="Get a listing of the Shipments.",
     *      tags={"Shipment"},
     *      description="Get all Shipments",
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
     *                  @OA\Items(ref="#/definitions/Shipment")
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
        $shipments = $this->shipmentRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($shipments->toArray(), 'Shipments requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/shipments",
     *      summary="Store a newly created Shipment in storage",
     *      tags={"Shipment"},
     *      description="Store Shipment",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Shipment")
     *          ),
     *          description="Shipment that should be stored",
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
     *                  ref="#/definitions/Shipment"
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

        $shipment = $this->shipmentRepository->create($input);

        return $this->sendResponse($shipment->toArray(), 'Shipment salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/shipments/{id}",
     *      summary="Display the specified Shipment",
     *      tags={"Shipment"},
     *      description="Get Shipment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Shipment",
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
     *                  ref="#/definitions/Shipment"
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
        /** @var Shipment $shipment */
        $shipment = $this->shipmentRepository->find($id);

        if (is_null($shipment)) {
            return $this->sendError('Shipment  não encontrada.');
        }

        return $this->sendResponse($shipment->toArray(), 'Shipment requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/shipments/{id}",
     *      summary="Update the specified Shipment in storage",
     *      tags={"Shipment"},
     *      description="Update Shipment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Shipment",
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
     *              @OA\Schema(ref="#/components/schemas/Shipment")
     *          ),
     *          description="Shipment that should be updated",
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
     *                  ref="#/definitions/Shipment"
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

        /** @var Shipment $shipment */
        $shipment = $this->shipmentRepository->find($id);

        if (is_null($shipment)) {
            return $this->sendError('Shipment  não encontrada.');
        }

        $shipment = $this->shipmentRepository->update($input, $id);

        return $this->sendResponse($shipment->toArray(), 'Shipment atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/shipments/{id}",
     *      summary="Remove the specified Shipment from storage",
     *      tags={"Shipment"},
     *      description="Delete Shipment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Shipment",
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
        /** @var Shipment $shipment */
        $shipment = $this->shipmentRepository->find($id);

        if (is_null($shipment)) {
            return $this->sendError('Shipment  não encontrada.');
        }

        $shipment->delete();

        return $this->sendSuccess('Shipment excluído com sucesso.');
    }
}
