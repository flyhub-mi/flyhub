<?php

namespace App\Http\Controllers\Tenant\API;

use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\ProductRepository;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers\API
 */
class ProductAPIController extends BaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/products",
     *      summary="Get a listing of the Products.",
     *      tags={"Product"},
     *      description="Get all Products",
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
     *                  @OA\Items(ref="#/definitions/Product")
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
        $products = $this->productRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($products->toArray(), 'Produtos requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/products",
     *      summary="Store a newly created Product in storage",
     *      tags={"Product"},
     *      description="Store Product",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Product")
     *          ),
     *          description="Product that should be stored",
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
     *                  ref="#/definitions/Product"
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
            $this->productRepository->create($request->input())->toArray(),
            'Produto salvo com sucesso.'
        );
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/products/{id}",
     *      summary="Display the specified Product",
     *      tags={"Product"},
     *      description="Get Product",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Product",
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
     *                  ref="#/definitions/Product"
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
        $product = $this->productRepository->find($id);

        if (is_null($product)) {
            return $this->sendError('Product   não encontrada.');
        }

        return $this->sendResponse($product->toArray(), 'Produto requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/products/{id}",
     *      summary="Update the specified Product in storage",
     *      tags={"Product"},
     *      description="Update Product",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Product",
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
     *              @OA\Schema(ref="#/components/schemas/Product")
     *          ),
     *          description="Product that should be updated",
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
     *                  ref="#/definitions/Product"
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
        $product = $this->productRepository->find($id);

        if (is_null($product)) {
            return $this->sendError('Product  não encontrada.');
        }

        $product->update($request->input());

        return $this->sendResponse($product->toArray(), 'Produto atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/products/{id}",
     *      summary="Remove the specified Product from storage",
     *      tags={"Product"},
     *      description="Delete Product",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Product",
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
        $product = $this->productRepository->find($id);

        if (is_null($product)) {
            return $this->sendError('Product  não encontrada.');
        }

        $product->delete();

        return $this->sendSuccess('Product excluído com sucesso.');
    }
}
