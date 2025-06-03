<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepositoryInterface;

    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
    {
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryRepositoryInterface->index();

        return ApiResponseClass::sendResponse(CategoryResource::collection($categories), 'Success get all categories', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $categoryRequest = [
            'name' => $request->name,
        ];

        DB::beginTransaction();

        try {
            $categoryResponse = $this->categoryRepositoryInterface->store($categoryRequest);

            DB::commit();
            return ApiResponseClass::sendResponse(new CategoryResource($categoryResponse), 'Category create successfully', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = $this->categoryRepositoryInterface->getById($category->id);

        return ApiResponseClass::sendResponse(new CategoryResource($category), 'Success get category by ID', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $categoryRequest = [
            'name' => $request->name,
        ];

        DB::beginTransaction();

        try {
            $categoryResponse = $this->categoryRepositoryInterface->update($categoryRequest, $category->id);

            DB::commit();
            return ApiResponseClass::sendResponse(new CategoryResource($categoryResponse), 'Update category successfully', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->categoryRepositoryInterface->delete($category->id);

        return ApiResponseClass::sendResponse($category->id, 'Delete category successfully', 204);
    }
}
