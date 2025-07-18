<?php

namespace App\Http\Controllers\Tenant\API;

use App\Http\Controllers\BaseController;
use App\Integration\Mapping\Utils;
use App\Repositories\Tenant\ChannelRepository;
use Illuminate\Http\Request;

/**
 * Class ChannelCategoryAPIController
 * @package App\Http\Controllers\API
 */
class ChannelCategoryAPIController extends BaseController
{
    /** @var  ChannelRepository */
    private $channelRepository;

    /**
     * ChannelCategoryAPIController constructor.
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
     *      path="/channel_categories/{channel}",
     *      summary="Get a listing of the Channel Categories.",
     *      tags={"ChannelCategory"},
     *      description="Get all ChannelCategory",
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
    public function index($channelId)
    {
        return $this->sendResponse($this->getChannelCategories($channelId), 'Categories requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/channel_categories/{channel}/{id}",
     *      summary="Display the specified ChannelCategory",
     *      tags={"ChannelCategory"},
     *      description="Get ChannelCategory",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ChannelCategory",
     *          @OA\Schema(
     *              type="string"
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
     *                  ref="#/definitions/ChannelCategory"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($channelId, $categoryId)
    {
        $channelCategories = $this->getChannelCategories($channelId, $categoryId);

        if (is_null($channelCategories)) {
            return $this->sendError('Categorias não encontradas.');
        }

        return $this->sendResponse($channelCategories->toArray(), 'Category requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/channel_categories/{channel}",
     *      summary="Store a newly created ChannelCategory in storage",
     *      tags={"Channel"},
     *      description="Store ChannelCategory",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ChannelCategory")
     *          ),
     *          description="Channel that should be stored",
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
     *                  ref="#/definitions/ChannelCategory"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store($channelId, Request $request)
    {
        $input = $request->input();

        $channel = $this->channelRepository->find($channelId);

        $channel = $channel
            ->channelCategories()
            ->updateOrCreate(
                ['category_id' => $input['category_id'], 'remote_category_id' => $input['remote_category_id']],
                ['remote_category_name' => $input['remote_category_name']],
            );

        return $this->sendResponse($channel->toArray(), 'Categoria do canal salva com sucesso.');
    }

    /**
     * @param $channelId
     * @param null $categoryId
     * @return array|\Illuminate\Http\JsonResponse|\Illuminate\Support\Collection|mixed
     */
    private function getChannelCategories($channelId, $categoryId = null)
    {
        $channel = $this->channelRepository->find($channelId);

        if (is_null($channel)) {
            return $this->sendError('Canal não encontrado.');
        }

        $configs = $channel->configs->pluck('value', 'code');

        $channelCategories = [];
        $categoryServiceNameSpace = Utils::buildNamespace('\App\Integration\Channels', $channel->code, 'Resources\Categories');

        if ($channel->code == 'MercadoLivre') {
            $categoryService = new $categoryServiceNameSpace($configs);
            $channelCategories = $categoryService->getAll($categoryId);
        } elseif ($channel->code == 'WooCommerce') {
            $categoryService = new $categoryServiceNameSpace($configs);
            $channelCategories = $categoryService->getAll();
        }
        return $channelCategories;
    }
}
