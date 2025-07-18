<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\DataTables\Tenant\TaxDataTable;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\TaxRateRepository;

class TaxesController extends BaseController
{
    /** @var  TaxRateRepository */
    private $taxRateRepository;

    /**
     * TaxesController constructor.
     * @param TaxRateRepository $taxRateRepo
     */
    public function __construct(TaxRateRepository $taxRateRepo)
    {
        $this->taxRateRepository = $taxRateRepo;
    }

    /**
     * @param TaxDataTable $taxRateDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(TaxDataTable $taxRateDataTable)
    {
        return $taxRateDataTable->render('tenant.settings.taxes.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.settings.taxes.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $taxRate = $this->taxRateRepository->create($input);

        Flash::success('Tax Rate criado.');

        return redirect(route('taxRates.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $taxRate = $this->taxRateRepository->find($id);

        if (is_null($taxRate)) {
            Flash::error('Tax Rate não encontrada.');

            return redirect(route('taxRates.index'));
        }

        return view('tenant.settings.taxes.show')->with('taxRate', $taxRate);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $taxRate = $this->taxRateRepository->find($id);

        if (is_null($taxRate)) {
            Flash::error('Tax Rate não encontrada.');

            return redirect(route('tax-rates.index'));
        }

        return view('tenant.settings.taxes.edit')->with('taxRate', $taxRate);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $taxRate = $this->taxRateRepository->find($id);

        if (is_null($taxRate)) {
            Flash::error('Tax Rate não encontrada.');

            return redirect(route('tax-rates.index'));
        }

        $taxRate = $this->taxRateRepository->update($request->input(), $id);

        Flash::success('Tax Rate atualizado.');

        return redirect(route('tax-rates.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $taxRate = $this->taxRateRepository->find($id);

        if (is_null($taxRate)) {
            Flash::error('Tax Rate não encontrada.');

            return redirect(route('tax-rates.index'));
        }

        $this->taxRateRepository->delete($id);

        Flash::success('Tax Rate excluído.');

        return redirect(route('tax-rates.index'));
    }
}
