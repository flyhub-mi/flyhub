<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\DataTables\Tenant\InventorySourceDataTable;
use App\Repositories\Tenant\InventorySourceRepository;

class InventorySourceController extends BaseController
{
    /** @var  InventorySourceRepository */
    private $modelRepository;

    /**
     * InventorySourceController constructor.
     * @param InventorySourceRepository $modelRepository
     */
    public function __construct(InventorySourceRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param InventorySourceDataTable $dataTable
     *
     * @return \Illuminate\View\View
     */
    public function index(InventorySourceDataTable $dataTable)
    {
        return $dataTable->render('tenant.settings.inventory-sources.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.settings.inventory-sources.create');
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

        Flash::success('Inventory Source criado.');

        return redirect(route('inventory-sources.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($id)
    {
        $model = $this->modelRepository->find($id);

        if (is_null($model)) {
            Flash::error('Inventory Source  não encontrada.');

            return redirect(route('inventory-sources.index'));
        }

        return view('tenant.settings.inventory-sources.show')->with('inventorySource', $model);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id)
    {
        $model = $this->modelRepository->find($id);

        if (is_null($model)) {
            Flash::error('Inventory Source  não encontrada.');

            return redirect(route('inventory-sources.index'));
        }

        return view('tenant.settings.inventory-sources.edit')->with('inventorySource', $model);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $model = $this->modelRepository->find($id);

        if (is_null($model)) {
            Flash::error('Inventory Source  não encontrada.');

            return redirect(route('inventory-sources.index'));
        }

        $this->modelRepository->update($request->input(), $id);

        Flash::success('Inventory Source atualizado.');

        return redirect(route('inventory-sources.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($id)
    {
        $model = $this->modelRepository->find($id);

        if (is_null($model)) {
            Flash::error('Inventory Source  não encontrada.');

            return redirect(route('inventory-sources.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success('Inventory Source excluído.');

        return redirect(route('inventory-sources.index'));
    }
}
