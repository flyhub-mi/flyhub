<?php

namespace App\Http\Controllers\Tenant\API;

use App\Repositories\Tenant\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

/**
 * Class OrderController
 * @package App\Http\Controllers\API
 */

class OrderAPIController extends BaseController
{
    /** @var  OrderRepository */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/orders",
     *      summary="Get a listing of the Orders.",
     *      tags={"Order"},
     *      description="Get all Orders",
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
     *                  @OA\Items(ref="#/definitions/Order")
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
        $orders = $this->orderRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($orders->toArray(), 'Pedidos requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/orders",
     *      summary="Store a newly created Order in storage",
     *      tags={"Order"},
     *      description="Store Order",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Order")
     *          ),
     *          description="Order that should be stored",
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
     *                  ref="#/definitions/Order"
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
        return $this->sendResponse(
            $this->orderRepository->create($request->input())->toArray(),
            'Pedido salvo com sucesso.'
        );
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/orders/{id}",
     *      summary="Display the specified Order",
     *      tags={"Order"},
     *      description="Get Order",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Order",
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
     *                  ref="#/definitions/Order"
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
        $order = $this->orderRepository->find($id);

        if (is_null($order)) {
            return $this->sendError('Pedido não encontrado.');
        }

        return $this->sendResponse($order->toArray(), 'Pedido requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/orders/{id}",
     *      summary="Update the specified Order in storage",
     *      tags={"Order"},
     *      description="Update Order",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Order",
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
     *              @OA\Schema(ref="#/components/schemas/Order")
     *          ),
     *          description="Order that should be updated",
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
     *                  ref="#/definitions/Order"
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

        $order = $this->orderRepository->find($id);

        if (is_null($order)) {
            return $this->sendError('Pedido não encontrado.');
        }

        $order = $this->orderRepository->update($input, $id);

        return $this->sendResponse($order->toArray(), 'Pedido atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/orders/{id}",
     *      summary="Remove the specified Order from storage",
     *      tags={"Order"},
     *      description="Delete Order",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Order",
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
        $order = $this->orderRepository->find($id);

        if (is_null($order)) {
            return $this->sendError('Pedido não encontrado.');
        }

        $order->delete();

        return $this->sendSuccess('Pedido excluído com sucesso.');
    }
}
