<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\DataTables\Tenant\TaxGroupDataTable;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\TaxGroupRepository;

class TaxGroupController extends BaseController
{
    private TaxGroupRepository $modelRepository;

    /**
     * @param TaxGroupRepository $modelRepository
     * @return void
     */
    public function __construct(TaxGroupRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param TaxGroupDataTable $taxCategoryDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(TaxGroupDataTable $taxCategoryDataTable)
    {
        return $taxCategoryDataTable->render('tenant.settings.tax-groups.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.settings.tax-groups.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $this->modelRepository->create($input);

        Flash::success('Tax Category criado.');

        return redirect(route('tax-group.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $taxGroup = $this->modelRepository->find($id);

        if (is_null($taxGroup)) {
            Flash::error('Tax Category  não encontrada.');

            return redirect(route('taxCategories.index'));
        }

        return view('tenant.settings.tax-groups.show')->with('taxGroup', $taxGroup);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $taxGroup = $this->modelRepository->find($id);

        if (is_null($taxGroup)) {
            Flash::error('Tax Category  não encontrada.');

            return redirect(route('tax-groups.index'));
        }

        return view('tenant.settings.tax-groups.edit')->with('taxGroup', $taxGroup);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $taxGroup = $this->modelRepository->find($id);

        if (is_null($taxGroup)) {
            Flash::error('Tax Category  não encontrada.');

            return redirect(route('tax-groups.index'));
        }

        $taxGroup = $this->modelRepository->update($request->input(), $id);

        Flash::success('Tax Category atualizado.');

        return redirect(route('tax-groups.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $taxGroup = $this->modelRepository->find($id);

        if (is_null($taxGroup)) {
            Flash::error('Tax Category  não encontrada.');

            return redirect(route('tax-groups.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success('Tax Category excluído.');

        return redirect(route('tax-groups.index'));
    }
}
