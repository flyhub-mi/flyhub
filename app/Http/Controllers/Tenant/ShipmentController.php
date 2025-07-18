<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\DataTables\Tenant\ShipmentDataTable;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\ShipmentRepository;

class ShipmentController extends BaseController
{
    /** @var  ShipmentRepository */
    private $shipmentRepository;

    /**
     * ShipmentController constructor.
     * @param ShipmentRepository $shipmentRepo
     */
    public function __construct(ShipmentRepository $shipmentRepo)
    {
        $this->shipmentRepository = $shipmentRepo;
    }

    /**
     * @param ShipmentDataTable $shipmentDataTable
     *
     * @return \Illuminate\View\View
     */
    public function index(ShipmentDataTable $shipmentDataTable)
    {
        return $shipmentDataTable->render('tenant.sales.shipments.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.sales.shipments.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $this->shipmentRepository->create($input);

        Flash::success('Shipment criado.');

        return redirect(route('shipments.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $shipment = $this->shipmentRepository->find($id);

        if (is_null($shipment)) {
            Flash::error('Shipment  não encontrada.');

            return redirect(route('shipments.index'));
        }

        return view('tenant.sales.shipments.show')->with('shipment', $shipment);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id)
    {
        $shipment = $this->shipmentRepository->find($id);

        if (is_null($shipment)) {
            Flash::error('Shipment  não encontrada.');

            return redirect(route('shipments.index'));
        }

        return view('tenant.sales.shipments.edit')->with('shipment', $shipment);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $shipment = $this->shipmentRepository->find($id);

        if (is_null($shipment)) {
            Flash::error('Shipment  não encontrada.');

            return redirect(route('shipments.index'));
        }

        $this->shipmentRepository->update($request->input(), $id);

        Flash::success('Shipment atualizado.');

        return redirect(route('shipments.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $shipment = $this->shipmentRepository->find($id);

        if (is_null($shipment)) {
            Flash::error('Shipment  não encontrada.');

            return redirect(route('shipments.index'));
        }

        $this->shipmentRepository->delete($id);

        Flash::success('Shipment excluído.');

        return redirect(route('shipments.index'));
    }
}
