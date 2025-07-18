<?php

namespace App\Http\Controllers\Tenant\API;

use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\ChannelRepository;

/**
 * Class ChannelCategoryAPIController
 * @package App\Http\Controllers\API
 */
class ChannelCategoryAttributeAPIController extends BaseController
{
    /** @var  ChannelRepository */
    private $channelRepository;

    /**
     * @param ChannelRepository $channelRepo
     */
    public function __construct(ChannelRepository $channelRepo)
    {
        $this->channelRepository = $channelRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/channels/{channelId}/categories/{categoryId}/attributes",
     *      summary="Get a listing of the Channel Category Attributes.",
     *      tags={"ChannelCategoryAttribute"},
     *      description="Get all ChannelCategoryAttribute",
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
     *                  type="array"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index($channelId, $categoryId)
    {
        return $this->sendResponse(
            $this->getChannelCategoryAttributes($channelId, $categoryId),
            'Atributos da categoria do canal requisitado com sucesso.',
        );
    }

    /**
     * @param $channelId
     * @param $categoryId
     * @return array|\Illuminate\Http\JsonResponse|\Illuminate\Support\Collection
     */
    private function getChannelCategoryAttributes($channelId, $categoryId)
    {
        $channel = $this->channelRepository->find($channelId);

        if (is_null($channel)) {
            return $this->sendError('Categorias não encontradas.');
        }

        $channelCategoryAttributes = [];

        if ($channel->code == 'MercadoLivre') {
            $categoryAtributesService = new \App\Integration\Channels\MercadoLivre\CategoryAttributes();
            $channelCategoryAttributes = $categoryAtributesService->getAll($categoryId);
        } elseif ($channel->code == 'Sisplan') {
            $attributesService = new \App\Integration\Channels\SisPlan\Attributes();
            $channelCategoryAttributes = $attributesService->getAll();
        }

        return $channelCategoryAttributes;
    }
}
