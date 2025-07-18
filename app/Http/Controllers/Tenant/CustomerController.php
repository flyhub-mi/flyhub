<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\DataTables\Tenant\CustomerDataTable;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\CustomerRepository;

class CustomerController extends BaseController
{
    /** @var  CustomerRepository */
    private $modelRepository;

    /**
     * CustomerController constructor.
     * @param CustomerRepository $modelRepository
     */
    public function __construct(CustomerRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param CustomerDataTable $customerDataTable
     *
     * @return \Illuminate\View\View
     */
    public function index(CustomerDataTable $customerDataTable)
    {
        return $customerDataTable->render('tenant.customers.index');
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($id)
    {
        $customer = $this->modelRepository->find($id);

        if (is_null($customer)) {
            Flash::error('Customer  não encontrada.');

            return redirect(route('customers.index'));
        }

        return view('tenant.customers.show')->with('customer', $customer);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $customer = $this->modelRepository->find($id);

        if (is_null($customer)) {
            Flash::error('Customer  não encontrada.');

            return redirect(route('customers.index'));
        }

        $this->modelRepository->update($request->input(), $id);

        Flash::success('Customer atualizado.');

        return redirect(route('customers.index'));
    }
}
