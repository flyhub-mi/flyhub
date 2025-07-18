<?php

namespace App\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\DataTables\TenantDataTable;
use App\Http\Controllers\BaseController;
use Illuminate\Contracts\View\View;
use App\Repositories\TenantRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;

class TenantController extends BaseController
{
    /** @var  TenantRepository */
    private $modelRepository;

    /** @param TenantRepository $modelRepository */
    public function __construct(TenantRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param TenantDataTable $tenantDataTable
     * @return mixed
     */
    public function index(TenantDataTable $tenantDataTable)
    {
        return $tenantDataTable->render('admin.tenants.index');
    }

    /**
     * @return View|Factory
     * @throws BindingResolutionException
     */
    public function create()
    {
        return view('admin.tenants.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $tenant = $this->modelRepository->create($input);

        Flash::success('Tenant criado.');

        return redirect(route('tenants.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $tenant = $this->modelRepository->find($id);

        if (is_null($tenant)) {
            Flash::error('Tenant  não encontrada.');

            return redirect(route('tenants.index'));
        }

        return view('admin.tenants.show')->with('tenant', $tenant);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $tenant = $this->modelRepository->find($id);

        if (is_null($tenant)) {
            Flash::error('Tenant  não encontrada.');

            return redirect(route('tenants.index'));
        }

        return view('admin.tenants.edit')->with('tenant', $tenant);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $tenant = $this->modelRepository->find($id);

        if (is_null($tenant)) {
            Flash::error('Tenant  não encontrada.');

            return redirect(route('tenants.index'));
        }

        $tenant = $this->modelRepository->update($request->input(), $id);

        Flash::success('Tenant atualizado.');

        return redirect(route('tenants.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tenant = $this->modelRepository->find($id);

        if (is_null($tenant)) {
            Flash::error('Tenant  não encontrada.');

            return redirect(route('tenants.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success('Tenant excluído.');

        return redirect(route('tenants.index'));
    }
}
