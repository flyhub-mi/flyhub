<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\InventorySource;
use App\Repositories\Tenant\InventorySourceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

/**
 * Class InventorySourceController
 * @package App\Http\Controllers\API
 */

class InventorySourceAPIController extends BaseController
{
    /** @var  InventorySourceRepository */
    private $inventorySourceRepository;

    public function __construct(InventorySourceRepository $inventorySourceRepo)
    {
        $this->inventorySourceRepository = $inventorySourceRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/inventory-sources",
     *      summary="Get a listing of the InventorySources.",
     *      tags={"InventorySource"},
     *      description="Get all InventorySources",
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
     *                  @OA\Items(ref="#/definitions/InventorySource")
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
        $inventorySources = $this->inventorySourceRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($inventorySources->toArray(), 'Inventory Sources requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/inventory-sources",
     *      summary="Store a newly created InventorySource in storage",
     *      tags={"InventorySource"},
     *      description="Store InventorySource",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/InventorySource")
     *          ),
     *          description="InventorySource that should be stored",
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
     *                  ref="#/definitions/InventorySource"
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

        $inventorySource = $this->inventorySourceRepository->create($input);

        return $this->sendResponse($inventorySource->toArray(), 'Inventory Source salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/inventory-sources/{id}",
     *      summary="Display the specified InventorySource",
     *      tags={"InventorySource"},
     *      description="Get InventorySource",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of InventorySource",
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
     *                  ref="#/definitions/InventorySource"
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
        /** @var InventorySource $inventorySource */
        $inventorySource = $this->inventorySourceRepository->find($id);

        if (is_null($inventorySource)) {
            return $this->sendError('Inventory Source não encontrado.');
        }

        return $this->sendResponse($inventorySource->toArray(), 'Inventory Source requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/inventory-sources/{id}",
     *      summary="Update the specified InventorySource in storage",
     *      tags={"InventorySource"},
     *      description="Update InventorySource",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of InventorySource",
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
     *              @OA\Schema(ref="#/components/schemas/InventorySource")
     *          ),
     *          description="InventorySource that should be updated",
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
     *                  ref="#/definitions/InventorySource"
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

        /** @var InventorySource $inventorySource */
        $inventorySource = $this->inventorySourceRepository->find($id);

        if (is_null($inventorySource)) {
            return $this->sendError('Inventory Source não encontrado.');
        }

        $inventorySource = $this->inventorySourceRepository->update($input, $id);

        return $this->sendResponse($inventorySource->toArray(), 'InventorySource atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/inventory-sources/{id}",
     *      summary="Remove the specified InventorySource from storage",
     *      tags={"InventorySource"},
     *      description="Delete InventorySource",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of InventorySource",
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
        /** @var InventorySource $inventorySource */
        $inventorySource = $this->inventorySourceRepository->find($id);

        if (is_null($inventorySource)) {
            return $this->sendError('Inventory Source não encontrado.');
        }

        $inventorySource->delete();

        return $this->sendSuccess('Inventory Source excluído com sucesso.');
    }
}
