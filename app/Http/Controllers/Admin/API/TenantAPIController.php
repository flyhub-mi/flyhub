<?php

namespace App\Http\Controllers\Admin\API;

use App\Models\Tenant;
use App\Repositories\TenantRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

/**
 * Class TenantController
 * @package App\Http\Controllers\API
 */

class TenantAPIController extends BaseController
{
    /** @var  TenantRepository */
    private $tenantRepository;

    public function __construct(TenantRepository $tenantRepo)
    {
        $this->tenantRepository = $tenantRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/tenants",
     *      summary="Get a listing of the Tenants.",
     *      tags={"Tenant"},
     *      description="Get all Tenants",
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
     *                  @OA\Items(ref="#/definitions/Tenant")
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
        $tenants = $this->tenantRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($tenants->toArray(), 'Inquilinos requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/tenants",
     *      summary="Store a newly created Tenant in storage",
     *      tags={"Tenant"},
     *      description="Store Tenant",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Tenant")
     *          ),
     *          description="Tenant that should be stored",
     *          required=false,
     *
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
     *                  ref="#/definitions/Tenant"
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

        $tenant = $this->tenantRepository->create($input);

        return $this->sendResponse($tenant->toArray(), 'Inquilino salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/tenants/{id}",
     *      summary="Display the specified Tenant",
     *      tags={"Tenant"},
     *      description="Get Tenant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tenant",
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
     *                  ref="#/definitions/Tenant"
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
        /** @var Tenant $tenant */
        $tenant = $this->tenantRepository->find($id);

        if (is_null($tenant)) {
            return $this->sendError('Tenant  não encontrada.');
        }

        return $this->sendResponse($tenant->toArray(), 'Inquilino requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/tenants/{id}",
     *      summary="Update the specified Tenant in storage",
     *      tags={"Tenant"},
     *      description="Update Tenant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tenant",
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
     *              @OA\Schema(ref="#/components/schemas/Tenant")
     *          ),
     *          description="Tenant that should be updated",
     *          required=false,
     *
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
     *                  ref="#/definitions/Tenant"
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

        /** @var Tenant $tenant */
        $tenant = $this->tenantRepository->find($id);

        if (is_null($tenant)) {
            return $this->sendError('Tenant  não encontrada.');
        }

        $tenant = $this->tenantRepository->update($input, $id);

        return $this->sendResponse($tenant->toArray(), 'Inquilino atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/tenants/{id}",
     *      summary="Remove the specified Tenant from storage",
     *      tags={"Tenant"},
     *      description="Delete Tenant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tenant",
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
        /** @var Tenant $tenant */
        $tenant = $this->tenantRepository->find($id);

        if (is_null($tenant)) {
            return $this->sendError('Tenant  não encontrada.');
        }

        $tenant->delete();

        return $this->sendSuccess('Tenant excluído com sucesso.');
    }
}
