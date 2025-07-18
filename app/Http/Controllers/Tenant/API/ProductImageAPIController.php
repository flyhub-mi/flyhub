<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Channel;
use App\Repositories\Tenant\ProductImageRepository;
use App\Repositories\Tenant\ProductRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProductController
 * @package App\Http\Controllers\API
 */
class ProductImageAPIController extends BaseController
{
    /** @var  ProductRepository */
    private $productRepository;
    private $productImageRepository;

    public function __construct(ProductRepository $productRepo, ProductImageRepository $productImageRepo)
    {
        $this->productRepository = $productRepo;
        $this->productImageRepository = $productImageRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/products/{id}/images",
     *      summary="Store a newly created ProductImage in storage",
     *      tags={"ProductImage"},
     *      description="Store ProductImage",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ProductImage")
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
     *                  ref="#/definitions/ProductImage"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(Request $request, $productId)
    {
        $product = $this->productRepository->find($productId);

        $folder = 'images/products/' . $productId;
        $path = Storage::disk('s3')->put($folder, $request->file);

        $createdImage = $product->images()->create(['path' => $path, 'channel_id' => Channel::first()->id]);

        return $this->sendResponse($createdImage, 'Imagem do produto salva com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/products/{id}/images/{id}",
     *      summary="Remove the specified ProductImage from storage",
     *      tags={"ProductImage"},
     *      description="Delete ProductImage",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductImage",
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
    public function destroy($productId, $imageId)
    {
        $image = $this->productImageRepository->find($imageId);

        if (is_null($image)) {
            return $this->sendError('Imagem do produto não encontrado.');
        }

        Storage::disk('s3')->delete($image->path);

        $image->delete();

        return $this->sendSuccess('Imagem do produto excluída com sucesso.');
    }
}
