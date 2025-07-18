<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\DataTables\Tenant\RefundDataTable;
use App\Repositories\Tenant\RefundRepository;
use App\Http\Controllers\BaseController;

class RefundController extends BaseController
{
    /** @var  RefundRepository */
    private $refundRepository;

    /**
     * RefundController constructor.
     * @param RefundRepository $refundRepo
     */
    public function __construct(RefundRepository $refundRepo)
    {
        $this->refundRepository = $refundRepo;
    }

    /**
     * @param RefundDataTable $refundDataTable
     * @return \Illuminate\View\View
     */
    public function index(RefundDataTable $refundDataTable)
    {
        return $refundDataTable->render('tenant.sales.refunds.index');
    }

    /**
     * Show the form for creating a new Refund.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.sales.refunds.create');
    }

    /**
     * Store a newly created Refund in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $refund = $this->refundRepository->create($input);

        Flash::success('Refund criado.');

        return redirect(route('refunds.index'));
    }

    /**
     * Display the specified Refund.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($id)
    {
        $refund = $this->refundRepository->find($id);

        if (is_null($refund)) {
            Flash::error('Refund  não encontrada.');

            return redirect(route('refunds.index'));
        }

        return view('tenant.sales.refunds.show')->with('refund', $refund);
    }

    /**
     * Show the form for editing the specified Refund.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id)
    {
        $refund = $this->refundRepository->find($id);

        if (is_null($refund)) {
            Flash::error('Refund  não encontrada.');

            return redirect(route('refunds.index'));
        }

        return view('tenant.sales.refunds.edit')->with('refund', $refund);
    }

    /**
     * Update the specified Refund in storage.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $refund = $this->refundRepository->find($id);

        if (is_null($refund)) {
            Flash::error('Refund  não encontrada.');

            return redirect(route('refunds.index'));
        }

        $this->refundRepository->update($request->input(), $id);

        Flash::success('Reembolso atualizado..');

        return redirect(route('refunds.index'));
    }

    /**
     * Remove the specified Refund from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $refund = $this->refundRepository->find($id);

        if (is_null($refund)) {
            Flash::error('Refund  não encontrada.');

            return redirect(route('refunds.index'));
        }

        $this->refundRepository->delete($id);

        Flash::success('Refund excluído.');

        return redirect(route('refunds.index'));
    }
}
