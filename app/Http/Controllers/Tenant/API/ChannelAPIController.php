<?php

namespace App\Http\Controllers\Tenant\API;

use App\Http\Controllers\BaseController;
use App\Models\Tenant\Channel;
use App\Repositories\Tenant\ChannelRepository;
use Illuminate\Http\Request;

/**
 * Class ChannelController
 * @package App\Http\Controllers\API
 */
class ChannelAPIController extends BaseController
{
    /** @var  ChannelRepository */
    private $channelRepository;

    /**
     * ChannelAPIController constructor.
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
     *      path="/channels",
     *      summary="Get a listing of the Channels.",
     *      tags={"Channel"},
     *      description="Get all Channels",
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
     *                  @OA\Items(ref="#/definitions/Channel")
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
        $channels = $this->channelRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($channels->toArray(), 'Canais requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/channels",
     *      summary="Store a newly created Channel in storage",
     *      tags={"Channel"},
     *      description="Store Channel",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Channel")
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
    public function store(Request $request)
    {
        $input = $request->input();

        $channel = $this->channelRepository->create($input);

        return $this->sendResponse($channel->toArray(), 'Canal salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/channels/{id}",
     *      summary="Display the specified Channel",
     *      tags={"Channel"},
     *      description="Get Channel",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Channel",
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
    public function show($id)
    {
        /** @var Channel $channel */
        $channel = $this->channelRepository->find($id);

        if (is_null($channel)) {
            return $this->sendError('Canal não encontrada.');
        }

        return $this->sendResponse($channel->toArray(), 'Canal requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/channels/{id}",
     *      summary="Update the specified Channel in storage",
     *      tags={"Channel"},
     *      description="Update Channel",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Channel",
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
     *              @OA\Schema(ref="#/components/schemas/Channel")
     *          ),
     *          description="Channel that should be updated",
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
    public function update($id, Request $request)
    {
        $input = $request->input();

        /** @var Channel $channel */
        $channel = $this->channelRepository->find($id);

        if (is_null($channel)) {
            return $this->sendError('Canal não encontrado.');
        }

        $channel = $this->channelRepository->update($input, $id);

        return $this->sendResponse($channel->toArray(), 'Canal atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     *
     * @OA\Delete(
     *      path="/channels/{id}",
     *      summary="Remove the specified Channel from storage",
     *      tags={"Channel"},
     *      description="Delete Channel",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Channel",
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
        /** @var Channel $channel */
        $channel = $this->channelRepository->find($id);

        if (is_null($channel)) {
            return $this->sendError('Channel   não encontrada.');
        }

        $channel->delete();

        return $this->sendSuccess('Channel excluído com sucesso.');
    }
}
