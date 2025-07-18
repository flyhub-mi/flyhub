<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use App\DataTables\Tenant\ProductDataTable;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\ProductRepository;
use App\Repositories\Tenant\AttributeSetRepository;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    private $productRepository;
    private $attributeSetRepository;

    /**
     * @param \App\Repositories\ProductRepository $productRepository
     * @param \App\Repositories\AttributeSetRepository $attributeSetRepository
     */
    public function __construct(ProductRepository $productRepository, AttributeSetRepository $attributeSetRepository)
    {
        $this->productRepository = $productRepository;
        $this->attributeSetRepository = $attributeSetRepository;
    }

    /**
     * @param \App\DataTables\Tenant\ProductDataTable $productDataTable
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function index(ProductDataTable $productDataTable)
    {
        return $productDataTable->render('tenant.catalog.products.index');
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.catalog.products.create')
            ->with('attributeSets', $this->attributeSetRepository->all()->pluck('name', 'id'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $product = $this->productRepository->create($input);

        Flash::success('Product criado.');

        return redirect(route('products.edit', ['product' => $product]));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $product = $this->productRepository->find($id);

        if (is_null($product)) {
            Flash::error('Product  não encontrada.');

            return redirect(route('products.index'));
        }

        return view('tenant.catalog.products.edit')->with('product', $product);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, $request)
    {
        $product = $this->productRepository->find($id);

        if (is_null($product)) {
            Flash::error('Product  não encontrada.');

            return redirect(route('products.index'));
        }

        $this->productRepository->update($request->input(), $id);

        Flash::success('Product atualizado.');

        return redirect(route('products.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if (is_null($product)) {
            Flash::error('Product  não encontrada.');

            return redirect(route('products.index'));
        }

        $this->productRepository->delete($id);

        Flash::success('Product excluído.');

        return redirect(route('products.index'));
    }
}
