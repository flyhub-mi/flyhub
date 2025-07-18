<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Channel;
use App\Models\Tenant\Product;
use App\Repositories\Tenant\ProductRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers\API
 */
class ProductChannelAPIController extends BaseController
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
     *      path="/products/{productId}/channels",
     *      summary="Get a listing of the Channels of Products.",
     *      tags={"ChannelProduct"},
     *      description="Get all Channels of Products",
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
     *                  @OA\Items(ref="#/definitions/ChannelProduct")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request, $productId)
    {
        $channels = $this->productRepository->find($productId)->channels();

        return $this->sendResponse($channels->toArray(), 'Canais do Produto requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/products/{id}/channels",
     *      summary="Store a newly created ChannelProduct in storage",
     *      tags={"ChannelProduct"},
     *      description="Store ChannelProduct",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ChannelProduct")
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
     *                  ref="#/definitions/ChannelProduct"
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
        $input = $request->input();
        /** @var Product $product */
        $product = $this->productRepository->find($productId);

        if (is_null($product)) {
            return $this->sendError('Product  não encontrada.');
        }

        $channel = Channel::where('code', $input['code'])->first();

        if (is_null($channel)) {
            return $this->sendError('Canal  não encontrado.');
        }

        $product->channels()->create(['channel_id' => $channel->id]);

        return $this->sendResponse(
            $product
                ->channels()
                ->get()
                ->toArray(),
            'Canal ativado no produto.',
        );
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/products/{id}/channels/{id}",
     *      summary="Remove the specified ChannelProduct from storage",
     *      tags={"ChannelProduct"},
     *      description="Delete ChannelProduct",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ChannelProduct",
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
     * @throws \Exception
     */
    public function destroy($productId, $channelId)
    {
        $product = $this->productRepository->find($productId);
        $channelProduct = $product
            ->channels()
            ->where('channel_id', $channelId)
            ->first();

        if (is_null($channelProduct)) {
            return $this->sendError('Canal do produto não encontrado.');
        }

        $channelProduct->delete();

        return $this->sendSuccess('Canal do produto desativado com sucesso.');
    }
}
