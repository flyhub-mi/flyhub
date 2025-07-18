<?php

namespace App\Http\Controllers\Tenant\API;

use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\ChannelRepository;
use Illuminate\Http\Request;

/**
 * Class ChannelProductAPIController
 * @package App\Http\Controllers\API
 */
class ChannelProductAPIController extends BaseController
{
    /** @var  ChannelRepository */
    private $channelRepo;

    /**
     * ChannelProductAttributeAPIController constructor.
     * @param ChannelRepository $channelRepo
     */
    public function __construct(ChannelRepository $channelRepo)
    {
        $this->channelRepo = $channelRepo;
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/channel/{channel_id}/products/{channel_product_id}",
     *      summary="Display the specified ChannelProduct",
     *      tags={"ChannelProduct"},
     *      description="Get ChannelProduct",
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
     *                  ref="#/definitions/Channel"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($channel_id, $channel_product_id)
    {
        /** @var ChannelRepository $channel */
        $channel = $this->channelRepo->find($channel_id);

        if (is_null($channel)) {
            return $this->sendError('Canal não encontrada.');
        }

        $channelProduct = $channel
            ->channelProducts()
            ->with('product.attributes')
            ->with('variations_attributes')
            ->find($channel_product_id);

        if (is_null($channelProduct)) {
            return $this->sendError('Produto do Canal não encontrada.');
        }

        return $this->sendResponse($channelProduct->toArray(), 'Produto do Canal requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/channel/{channel_id}/products/{channel_product_id}",
     *      summary="Update the specified ChannelProduct in storage",
     *      tags={"ChannelProduct"},
     *      description="Store ChannelProduct",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ChannelProduct")
     *          ),
     *          description="ChannelProduct that should be stored",
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
    public function update($channel_id, $channel_product_id, Request $request)
    {
        $input = $request->input();

        $channel = $this->channelRepo->find($channel_id);

        if (is_null($channel)) {
            return $this->sendError('Canal não encontrada.');
        }

        $channelProduct = $channel
            ->products()
            ->with('attributes')
            ->find($channel_product_id);

        if (is_null($channelProduct)) {
            return $this->sendError('Produto do Canal não encontrada.');
        }

        foreach ($input['attributes'] as $code => $value) {
            $channelProduct->attributes()->updateOrCreate(['code' => $code], ['value' => $value]);
        }

        foreach ($input['variations'] as $id => $variation) {
            $channelProduct = $channel
                ->products()
                ->with('attributes')
                ->firstOrCreate([
                    'product_id' => $variation['product_id'],
                ]);

            foreach ($variation['attributes'] as $code => $value) {
                $channelProduct->attributes()->updateOrCreate(['code' => $code], ['value' => $value]);
            }
        }

        return $this->sendResponse([], 'Produto do canal atualizado com sucesso.');
    }
}
