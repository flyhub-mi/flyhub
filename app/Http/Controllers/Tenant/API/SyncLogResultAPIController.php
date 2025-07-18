<?php

namespace App\Http\Controllers\Tenant\API;

use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\SyncLogRepository;
use Illuminate\Http\Request;

/**
 * Class ChannelSyncLogResultAPIController
 * @package App\Http\Controllers\API
 */
class SyncLogResultAPIController extends BaseController
{
    /** @var  SyncLogRepository */
    private $syncLogRepositorysitory;

    /**
     * ChannelSyncLogAttributeAPIController constructor.
     * @param SyncLogRepository $syncLogRepositorysitory
     */
    public function __construct(SyncLogRepository $syncLogRepositorysitory)
    {
        $this->syncLogRepositorysitory = $syncLogRepositorysitory;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/channel-sync-logs/{$syncLogId}/results",
     *      summary="Get a listing of the Channel Sync Logs.",
     *      tags={"ChannelSyncLogResult"},
     *      description="Get all Channel Sync Log Results",
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
     *                  @OA\Items(ref="#/definitions/ChannelSyncLogResult")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request, $syncLogId)
    {
        $syncLogs = $this->syncLogRepositorysitory->allLogResults(
            $syncLogId,
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse(
            $syncLogs->toArray(),
            'Logos de Sincronização do canal requisitado com sucesso.',
        );
    }
}
