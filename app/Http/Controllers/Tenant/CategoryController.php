<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Category;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\CategoryRepository;

class CategoryController extends BaseController
{
    /** @var  CategoryRepository */
    private $modelRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $modelRepository
     */
    public function __construct(CategoryRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::get()->toTree();

        return view('tenant.catalog.categories.index')->with('categories', $categories);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.catalog.categories.create');
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

        Flash::success('Category criado.');

        return redirect(route('categories.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $category = $this->modelRepository->find($id);

        if (is_null($category)) {
            Flash::error('Category não encontrado.');

            return redirect(route('categories.index'));
        }

        return view('tenant.catalog.categories.show')->with('category', $category);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->modelRepository->find($id);

        if (is_null($category)) {
            Flash::error('Category não encontrado.');

            return redirect(route('categories.index'));
        }

        return view('tenant.catalog.categories.edit')->with('category', $category);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $category = $this->modelRepository->find($id);

        if (is_null($category)) {
            Flash::error('Category não encontrado.');

            return redirect(route('categories.index'));
        }

        $this->modelRepository->update($request->input(), $id);

        Flash::success('Category atualizado.');

        return redirect(route('categories.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $category = $this->modelRepository->find($id);

        if (is_null($category)) {
            Flash::error('Category não encontrado.');

            return redirect(route('categories.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success('Category excluído.');

        return redirect(route('categories.index'));
    }
}
