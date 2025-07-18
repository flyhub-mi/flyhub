<?php

namespace App\Http\Controllers\Tenant\API;

use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\SyncLogRepository;
use Illuminate\Http\Request;

/**
 * Class SyncLogAPIController
 * @package App\Http\Controllers\API
 */
class SyncLogAPIController extends BaseController
{
    /** @var  SyncLogRepository */
    private $syncLogRepository;

    /** @param SyncLogRepository $syncLogRepositorysitory */
    public function __construct(SyncLogRepository $syncLogRepositorysitory)
    {
        $this->syncLogRepository = $syncLogRepositorysitory;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/channel-sync-logs",
     *      summary="Get a listing of the Channel Sync Logs.",
     *      tags={"SyncLog"},
     *      description="Get all Channel Sync Logs",
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
     *                  @OA\Items(ref="#/definitions/SyncLog")
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
        $syncLogs = $this->syncLogRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse(
            $syncLogs->toArray(),
            'Logos de Sincronização do canal requisitado com sucesso.',
        );
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/channel-sync-logs/{id}",
     *      summary="Display the specified SyncLog",
     *      tags={"SyncLog"},
     *      description="Get SyncLog",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of SyncLog",
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
     *                  ref="#/definitions/SyncLog"
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
        /** @var SyncLogRepository $syncLog */
        $syncLog = $this->syncLogRepository->find($id);

        if (is_null($syncLog)) {
            return $this->sendError('Log de sincronização do canal não encontrado.');
        }

        return $this->sendResponse(
            $syncLog->toArray(),
            'Log de sincronização do Canal requisitado com sucesso.',
        );
    }
}
