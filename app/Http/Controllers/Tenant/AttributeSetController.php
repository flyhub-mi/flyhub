<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\DataTables\Tenant\AttributeSetDataTable;
use App\Repositories\Tenant\AttributeSetRepository;

class AttributeSetController extends BaseController
{
    /** @var  AttributeSetRepository */
    private $modelRepository;

    /**
     * AttributeSetController constructor.
     * @param AttributeSetRepository $modelRepository
     */
    public function __construct(AttributeSetRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param AttributeSetDataTable $attributeSetDataTable
     *
     * @return \Illuminate\View\View
     */
    public function index(AttributeSetDataTable $attributeSetDataTable)
    {
        return $attributeSetDataTable->render('tenant.catalog.attribute-sets.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.catalog.attribute-sets.create');
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

        Flash::success('Attribute Set criado.');

        return redirect(route('attribute-sets.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($id)
    {
        $attributeSet = $this->modelRepository->find($id);

        if (is_null($attributeSet)) {
            Flash::error('Attribute Set  não encontrada.');

            return redirect(route('attribute-sets.index'));
        }

        return view('tenant.catalog.attribute-sets.show')->with('attributeSet', $attributeSet);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id)
    {
        $attributeSet = $this->modelRepository->find($id);

        if (is_null($attributeSet)) {
            Flash::error('Attribute Set  não encontrada.');

            return redirect(route('attribute-sets.index'));
        }

        return view('tenant.catalog.attribute-sets.edit')->with('attributeSet', $attributeSet);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $attributeSet = $this->modelRepository->find($id);

        if (is_null($attributeSet)) {
            Flash::error('Attribute Set  não encontrada.');

            return redirect(route('attribute-sets.index'));
        }

        $this->modelRepository->update($request->input(), $id);

        Flash::success('Attribute Set atualizado.');

        return redirect(route('attribute-sets.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($id)
    {
        $attributeSet = $this->modelRepository->find($id);

        if (is_null($attributeSet)) {
            Flash::error('Attribute Set  não encontrada.');

            return redirect(route('attribute-sets.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success('Attribute Set excluído.');

        return redirect(route('attribute-sets.index'));
    }
}
