<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use App\DataTables\Tenant\OrderDataTable;
use App\Repositories\Tenant\OrderRepository;
use App\Http\Controllers\BaseController;
use App\Models\Tenant\InventorySource;

class OrderController extends BaseController
{
    private $modelRepository;

    /**
     * OrderController constructor.
     * @param OrderRepository $modelRepository
     */
    public function __construct(OrderRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param OrderDataTable $orderDataTable
     * @return \Illuminate\View\View
     */
    public function index(OrderDataTable $orderDataTable)
    {
        return $orderDataTable->render('tenant.sales.orders.index');
    }

    /**
     * Show the form for creating a new Order.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.sales.orders.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store($request)
    {
        $input = $request->input();

        $this->modelRepository->create($input);

        Flash::success('Pedido criado.');

        return redirect(route('orders.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($id)
    {
        $order = $this->modelRepository->find($id);

        if (is_null($order)) {
            Flash::error('Pedido não encontrado.');
            return redirect(route('orders.index'));
        }

        $inventorySource = InventorySource::first();

        return view('tenant.sales.orders.show')
            ->with('order', $order)
            ->with('inventorySource', $inventorySource)
            ->with('invoice', $order->invoices()->first());
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id)
    {
        $order = $this->modelRepository->find($id);

        if (is_null($order)) {
            Flash::error('Pedido não encontrado.');

            return redirect(route('orders.index'));
        }

        return view('tenant.sales.orders.edit')->with('order', $order);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, $request)
    {
        $order = $this->modelRepository->find($id);

        if (is_null($order)) {
            Flash::error('Pedido não encontrado.');

            return redirect(route('orders.index'));
        }

        $this->modelRepository->update($request->input(), $id);

        Flash::success('Pedido atualizado.');

        return redirect(route('orders.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $order = $this->modelRepository->find($id);

        if (is_null($order)) {
            Flash::error('Pedido não encontrado.');

            return redirect(route('orders.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success('Pedido excluído.');

        return redirect(route('orders.index'));
    }
}
