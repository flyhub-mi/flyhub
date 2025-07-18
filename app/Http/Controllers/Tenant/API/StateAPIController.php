<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\State;
use App\Repositories\Tenant\StateRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class StateController
 * @package App\Http\Controllers\API
 */

class StateAPIController extends BaseController
{
    /** @var  StateRepository */
    private $stateRepository;

    /**
     * StateAPIController constructor.
     * @param StateRepository $stateRepo
     */
    public function __construct(StateRepository $stateRepo)
    {
        $this->stateRepository = $stateRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/states",
     *      summary="Get a listing of the States.",
     *      tags={"State"},
     *      description="Get all States",
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
     *                  @OA\Items(ref="#/definitions/State")
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
        $states = $this->stateRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($states->toArray(), 'States requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/states",
     *      summary="Store a newly created State in storage",
     *      tags={"State"},
     *      description="Store State",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/State")
     *          ),
     *          description="State that should be stored",
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
     *                  ref="#/definitions/State"
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

        $state = $this->stateRepository->create($input);

        return $this->sendResponse($state->toArray(), 'State salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/states/{id}",
     *      summary="Display the specified State",
     *      tags={"State"},
     *      description="Get State",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of State",
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
     *                  ref="#/definitions/State"
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
        /** @var State $state */
        $state = $this->stateRepository->find($id);

        if (is_null($state)) {
            return $this->sendError('State   não encontrada.');
        }

        return $this->sendResponse($state->toArray(), 'State requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/states/{id}",
     *      summary="Update the specified State in storage",
     *      tags={"State"},
     *      description="Update State",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of State",
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
     *              @OA\Schema(ref="#/components/schemas/State")
     *          ),
     *          description="State that should be updated",
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
     *                  ref="#/definitions/State"
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

        /** @var State $state */
        $state = $this->stateRepository->find($id);

        if (is_null($state)) {
            return $this->sendError('State   não encontrada.');
        }

        $state = $this->stateRepository->update($input, $id);

        return $this->sendResponse($state->toArray(), 'State atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     *
     * @OA\Delete(
     *      path="/states/{id}",
     *      summary="Remove the specified State from storage",
     *      tags={"State"},
     *      description="Delete State",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of State",
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
        /** @var State $state */
        $state = $this->stateRepository->find($id);

        if (is_null($state)) {
            return $this->sendError('State não encontrado.');
        }

        $state->delete();

        return $this->sendSuccess('State excluído com sucesso.');
    }
}
