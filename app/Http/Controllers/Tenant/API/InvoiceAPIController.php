<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Invoice;
use App\Repositories\Tenant\InvoiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

/**
 * Class InvoiceController
 * @package App\Http\Controllers\API
 */

class InvoiceAPIController extends BaseController
{
    /** @var  InvoiceRepository */
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepo)
    {
        $this->invoiceRepository = $invoiceRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/invoices",
     *      summary="Get a listing of the Invoices.",
     *      tags={"Invoice"},
     *      description="Get all Invoices",
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
     *                  @OA\Items(ref="#/definitions/Invoice")
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
        $invoices = $this->invoiceRepository->all(
            $request->except(['skip', 'limit']),
            $request->input('skip'),
            $request->input('limit'),
        );

        return $this->sendResponse($invoices->toArray(), 'Invoices requisitado com sucesso.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/invoices",
     *      summary="Store a newly created Invoice in storage",
     *      tags={"Invoice"},
     *      description="Store Invoice",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Invoice")
     *          ),
     *          description="Invoice that should be stored",
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
     *                  ref="#/definitions/Invoice"
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

        $invoice = $this->invoiceRepository->create($input);

        return $this->sendResponse($invoice->toArray(), 'Invoice salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/invoices/{id}",
     *      summary="Display the specified Invoice",
     *      tags={"Invoice"},
     *      description="Get Invoice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Invoice",
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
     *                  ref="#/definitions/Invoice"
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
        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->find($id);

        if (is_null($invoice)) {
            return $this->sendError('Invoice   não encontrada.');
        }

        return $this->sendResponse($invoice->toArray(), 'Invoice requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/invoices/{id}",
     *      summary="Update the specified Invoice in storage",
     *      tags={"Invoice"},
     *      description="Update Invoice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Invoice",
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
     *              @OA\Schema(ref="#/components/schemas/Invoice")
     *          ),
     *          description="Invoice that should be updated",
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
     *                  ref="#/definitions/Invoice"
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

        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->find($id);

        if (is_null($invoice)) {
            return $this->sendError('Invoice   não encontrada.');
        }

        $invoice = $this->invoiceRepository->update($input, $id);

        return $this->sendResponse($invoice->toArray(), 'Invoice atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/invoices/{id}",
     *      summary="Remove the specified Invoice from storage",
     *      tags={"Invoice"},
     *      description="Delete Invoice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Invoice",
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
        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->find($id);

        if (is_null($invoice)) {
            return $this->sendError('Invoice   não encontrada.');
        }

        $invoice->delete();

        return $this->sendSuccess('Invoice excluído com sucesso.');
    }
}
