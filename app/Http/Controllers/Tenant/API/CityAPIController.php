<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\City;
use App\Repositories\Tenant\CityRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class CityController
 * @package App\Http\Controllers\API
 */
class CityAPIController extends BaseController
{
    /** @var  CityRepository */
    private $cityRepository;

    /**
     * CityAPIController constructor.
     * @param CityRepository $cityRepo
     */
    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepository = $cityRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/cities",
     *      summary="Get a listing of the Cities.",
     *      tags={"City"},
     *      description="Get all Cities",
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
     *                  @OA\Items(ref="#/definitions/City")
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
        $citys = $this->cityRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($citys->toArray(), 'Cidade requisitada com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/cities",
     *      summary="Store a newly created City in storage",
     *      tags={"City"},
     *      description="Store City",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/City")
     *          ),
     *          description="City that should be stored",
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
     *                  ref="#/definitions/City"
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

        $city = $this->cityRepository->create($input);

        return $this->sendResponse($city->toArray(), 'Cidade salva com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/cities/{id}",
     *      summary="Display the specified City",
     *      tags={"City"},
     *      description="Get City",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of City",
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
     *                  ref="#/definitions/City"
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
        /** @var City $city */
        $city = $this->cityRepository->find($id);

        if (is_null($city)) {
            return $this->sendError('Cidade não encontrada.');
        }

        return $this->sendResponse($city->toArray(), 'Cidade requisitada com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/cities/{id}",
     *      summary="Update the specified City in storage",
     *      tags={"City"},
     *      description="Update City",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of City",
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
     *              @OA\Schema(ref="#/components/schemas/City")
     *          ),
     *          description="City that should be updated",
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
     *                  ref="#/definitions/City"
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

        /** @var City $city */
        $city = $this->cityRepository->find($id);

        if (is_null($city)) {
            return $this->sendError('Cidade não encontrada.');
        }

        $city = $this->cityRepository->update($input, $id);

        return $this->sendResponse($city->toArray(), 'Cidade atualizada.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     *
     * @OA\Delete(
     *      path="/cities/{id}",
     *      summary="Remove the specified City from storage",
     *      tags={"City"},
     *      description="Delete City",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of City",
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
        /** @var City $city */
        $city = $this->cityRepository->find($id);

        if (is_null($city)) {
            return $this->sendError('Cidade não encontrada.');
        }

        $city->delete();

        return $this->sendSuccess('Cidade excluído com sucesso.');
    }
}
