<?php

namespace App\Http\Controllers\Tenant\API;

use App\Models\Tenant\Category;
use App\Repositories\Tenant\CategoryRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 * @package App\Http\Controllers\API
 */
class CategoryAPIController extends BaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    /**
     * CategoryAPIController constructor.
     * @param CategoryRepository $categoryRepo
     */
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/categories",
     *      summary="Get a listing of the Categories.",
     *      tags={"Category"},
     *      description="Get all Categories",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/definitions/Category")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index()
    {
        return $this->sendResponse(
            $this->categoryRepository
                ->all()
                ->toTree()
                ->toArray(),
            'Categories requisitado com sucesso.',
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/categories",
     *      summary="Store a newly created Category in storage",
     *      tags={"Category"},
     *      description="Store Category",
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Category")
     *          ),
     *          description="Category that should be stored",
     *          required=false
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/definitions/Category"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $category = $this->categoryRepository->create($input);

        return $this->sendResponse($category->toArray(), 'Category salvo com sucesso.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/categories/{id}",
     *      summary="Display the specified Category",
     *      tags={"Category"},
     *      description="Get Category",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Category",
     *          @OA\Schema(
     *             type="integer",
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/definitions/Category"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (is_null($category)) {
            return $this->sendError('Category   não encontrada.');
        }

        return $this->sendResponse($category->toArray(), 'Category requisitado com sucesso.');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/categories/{id}",
     *      summary="Update the specified Category in storage",
     *      tags={"Category"},
     *      description="Update Category",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Category",
     *          @OA\Schema(
     *             type="integer",
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *          description="Created user object",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Category")
     *          ),
     *          description="Category that should be updated",
     *          required=false
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/definitions/Category"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, Request $request)
    {
        $input = $request->input();

        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (is_null($category)) {
            return $this->sendError('Category   não encontrada.');
        }

        $category = $this->categoryRepository->update($input, $id);

        return $this->sendResponse($category->toArray(), 'Category atualizado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *      path="/categories/{id}",
     *      summary="Remove the specified Category from storage",
     *      tags={"Category"},
     *      description="Delete Category",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Category",
     *          @OA\Schema(
     *             type="integer",
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (is_null($category)) {
            return $this->sendError('Category   não encontrada.');
        }

        $category->delete();

        return $this->sendSuccess('Category excluído com sucesso.');
    }
}
