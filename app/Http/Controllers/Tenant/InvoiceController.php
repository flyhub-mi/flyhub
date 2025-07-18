<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\DataTables\Tenant\InvoiceDataTable;
use App\Http\Controllers\BaseController;
use App\Models\Tenant\InventorySource;
use App\Models\Tenant\Invoice;
use App\Repositories\Tenant\InvoiceRepository;

class InvoiceController extends BaseController
{
    /** @var  InvoiceRepository */
    private $modelRepository;

    /**
     * InvoiceController constructor.
     * @param InvoiceRepository $modelRepository
     */
    public function __construct(InvoiceRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param InvoiceDataTable $invoiceDataTable
     * @return \Illuminate\View\View
     */
    public function index(InvoiceDataTable $invoiceDataTable)
    {
        return $invoiceDataTable->render('tenant.sales.invoices.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.sales.invoices.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $this->modelRepository->create($input);

        Flash::success('Invoice criado.');

        return redirect(route('invoices.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($id)
    {
        $invoice = Invoice::with(['order', 'order.billingAddress', 'order.shippingAddress'])->find($id);

        if (is_null($invoice)) {
            Flash::error('Invoice  não encontrada.');

            return redirect(route('invoices.index'));
        }

        $inventorySource = InventorySource::first();

        return view('tenant.sales.invoices.show')
            ->with('invoice', $invoice)
            ->with('inventorySource', $inventorySource);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id)
    {
        $invoice = $this->modelRepository->find($id);

        if (is_null($invoice)) {
            Flash::error('Invoice  não encontrada.');

            return redirect(route('invoices.index'));
        }

        return view('tenant.sales.invoices.edit')->with('invoice', $invoice);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $invoice = $this->modelRepository->find($id);

        if (is_null($invoice)) {
            Flash::error('Invoice  não encontrada.');

            return redirect(route('invoices.index'));
        }

        $this->modelRepository->update($request->input(), $id);

        Flash::success('Invoice atualizado.');

        return redirect(route('invoices.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $invoice = $this->modelRepository->find($id);

        if (is_null($invoice)) {
            Flash::error('Invoice  não encontrada.');

            return redirect(route('invoices.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success('Invoice excluído.');

        return redirect(route('invoices.index'));
    }
}
