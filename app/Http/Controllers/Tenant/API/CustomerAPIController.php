<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Customer;
use App\Repositories\Tenant\CustomerRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class CustomerController
 * @package App\Http\Controllers\API
 */

class CustomerAPIController extends BaseController
{
    /** @var  CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/customers",
     *      summary="Get a listing of the Customers.",
     *      tags={"Customer"},
     *      description="Get all Customers",
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
     *                  @OA\Items(ref="#/definitions/Customer")
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
        $customers = $this->customerRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($customers->toArray(), 'Customers requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/customers",
     *      summary="Store a newly created Customer in storage",
     *      tags={"Customer"},
     *      description="Store Customer",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Customer")
     *          ),
     *          description="Customer that should be stored",
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
     *                  ref="#/definitions/Customer"
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

        $customer = $this->customerRepository->create($input);

        return $this->sendResponse($customer->toArray(), 'Customer salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/customers/{id}",
     *      summary="Display the specified Customer",
     *      tags={"Customer"},
     *      description="Get Customer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Customer",
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
     *                  ref="#/definitions/Customer"
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
        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (is_null($customer)) {
            return $this->sendError('Customer não encontrado.');
        }

        return $this->sendResponse($customer->toArray(), 'Customer requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/customers/{id}",
     *      summary="Update the specified Customer in storage",
     *      tags={"Customer"},
     *      description="Update Customer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Customer",
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
     *              @OA\Schema(ref="#/components/schemas/Customer")
     *          ),
     *          description="Customer that should be updated",
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
     *                  ref="#/definitions/Customer"
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

        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (is_null($customer)) {
            return $this->sendError('Customer não encontrado.');
        }

        $customer = $this->customerRepository->update($input, $id);

        return $this->sendResponse($customer->toArray(), 'Customer atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/customers/{id}",
     *      summary="Remove the specified Customer from storage",
     *      tags={"Customer"},
     *      description="Delete Customer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Customer",
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
        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (is_null($customer)) {
            return $this->sendError('Customer não encontrado.');
        }

        $customer->delete();

        return $this->sendSuccess('Customer excluído com sucesso.');
    }
}
