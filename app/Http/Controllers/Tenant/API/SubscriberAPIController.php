<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Subscriber;
use App\Repositories\Tenant\SubscriberRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

/**
 * Class SubscriberController
 * @package App\Http\Controllers\API
 */

class SubscriberAPIController extends BaseController
{
    /** @var  SubscriberRepository */
    private $subscriberRepository;

    public function __construct(SubscriberRepository $subscriberRepo)
    {
        $this->subscriberRepository = $subscriberRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/subscribers",
     *      summary="Get a listing of the Subscribers.",
     *      tags={"Subscriber"},
     *      description="Get all Subscribers",
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
     *                  @OA\Items(ref="#/definitions/Subscriber")
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
        $subscribers = $this->subscriberRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($subscribers->toArray(), 'Subscribers requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/subscribers",
     *      summary="Store a newly created Subscriber in storage",
     *      tags={"Subscriber"},
     *      description="Store Subscriber",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Subscriber")
     *          ),
     *          description="Subscriber that should be stored",
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
     *                  ref="#/definitions/Subscriber"
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

        $subscriber = $this->subscriberRepository->create($input);

        return $this->sendResponse($subscriber->toArray(), 'Subscriber salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/subscribers/{id}",
     *      summary="Display the specified Subscriber",
     *      tags={"Subscriber"},
     *      description="Get Subscriber",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Subscriber",
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
     *                  ref="#/definitions/Subscriber"
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
        /** @var Subscriber $subscriber */
        $subscriber = $this->subscriberRepository->find($id);

        if (is_null($subscriber)) {
            return $this->sendError('Subscriber  não encontrada.');
        }

        return $this->sendResponse($subscriber->toArray(), 'Subscriber requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/subscribers/{id}",
     *      summary="Update the specified Subscriber in storage",
     *      tags={"Subscriber"},
     *      description="Update Subscriber",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Subscriber",
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
     *              @OA\Schema(ref="#/components/schemas/Subscriber")
     *          ),
     *          description="Subscriber that should be updated",
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
     *                  ref="#/definitions/Subscriber"
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

        /** @var Subscriber $subscriber */
        $subscriber = $this->subscriberRepository->find($id);

        if (is_null($subscriber)) {
            return $this->sendError('Subscriber  não encontrada.');
        }

        $subscriber = $this->subscriberRepository->update($input, $id);

        return $this->sendResponse($subscriber->toArray(), 'Subscriber atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/subscribers/{id}",
     *      summary="Remove the specified Subscriber from storage",
     *      tags={"Subscriber"},
     *      description="Delete Subscriber",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Subscriber",
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
        /** @var Subscriber $subscriber */
        $subscriber = $this->subscriberRepository->find($id);

        if (is_null($subscriber)) {
            return $this->sendError('Subscriber  não encontrada.');
        }

        $subscriber->delete();

        return $this->sendSuccess('Subscriber excluído com sucesso.');
    }
}
