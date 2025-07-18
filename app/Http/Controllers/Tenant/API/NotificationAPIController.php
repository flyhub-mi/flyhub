<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Notification;
use App\Repositories\Tenant\NotificationRepository;
use App\Http\Controllers\BaseController;

/**
 * Class NotificationController
 * @package App\Http\Controllers\API
 */
class NotificationAPIController extends BaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/notifications/{id}",
     *      summary="Display the specified Notification",
     *      tags={"Notification"},
     *      description="Get Notification",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Notification",
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
     *                  ref="#/definitions/Notification"
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
        /** @var Notification $attribute */
        $notification = $this->notificationRepository->find($id);

        if (is_null($attribute)) {
            return $this->sendError('Notificação não encontrada.');
        }

        $notification->markAsRead();

        return $this->sendResponse($attribute->toArray(), 'Notificação requisitada com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/notifications/{id}",
     *      summary="Remove the specified Notification from storage",
     *      tags={"Notification"},
     *      description="Delete Notification",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Notification",
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
        /** @var Notification $notification */
        $notification = $this->notificationRepository->find($id);
        if (is_null($notification)) {
            return $this->sendError('Notificação não encontrada.');
        }

        $notification->delete();

        return $this->sendSuccess('Notificação excluída com sucesso.');
    }
}
