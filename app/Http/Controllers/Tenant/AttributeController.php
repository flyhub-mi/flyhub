<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\DataTables\Tenant\AttributeDataTable;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\AttributeRepository;

class AttributeController extends BaseController
{
    /** @var  AttributeRepository */
    private $modelRepository;

    /**
     * AttributeController constructor.
     * @param AttributeRepository $modelRepository
     */
    public function __construct(AttributeRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param AttributeDataTable $attributeDataTable
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(AttributeDataTable $attributeDataTable)
    {
        return $attributeDataTable->render('tenant.catalog.attributes.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.catalog.attributes.create');
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

        Flash::success('Attribute criado.');

        return redirect(route('attributes.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($id)
    {
        $attribute = $this->modelRepository->find($id);

        if (is_null($attribute)) {
            Flash::error('Attribute  não encontrada.');

            return redirect(route('attributes.index'));
        }

        return view('tenant.catalog.attributes.show')->with('attribute', $attribute);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $attribute = $this->modelRepository->find($id);

        if (is_null($attribute)) {
            Flash::error('Attribute  não encontrada.');

            return redirect(route('attributes.index'));
        }

        return view('tenant.catalog.attributes.edit')->with('attribute', $attribute);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $attribute = $this->modelRepository->find($id);

        if (is_null($attribute)) {
            Flash::error('Attribute  não encontrada.');

            return redirect(route('attributes.index'));
        }

        $this->modelRepository->update($request->input(), $id);

        Flash::success('Attribute atualizado.');

        return redirect(route('attributes.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $attribute = $this->modelRepository->find($id);

        if (is_null($attribute)) {
            Flash::error('Attribute  não encontrada.');

            return redirect(route('attributes.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success('Attribute excluído.');

        return redirect(route('attributes.index'));
    }
}
