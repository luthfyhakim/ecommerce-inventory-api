<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\UpdateStockProductRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productRepositoryInterface->index();

        return ApiResponseClass::sendResponse(ProductResource::collection($products), 'Succes get all products', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $productRequest = [
            'name' => $request->name,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
        ];

        DB::beginTransaction();

        try {
            $productResponse = $this->productRepositoryInterface->store($productRequest);

            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($productResponse), 'Create product successfully', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepositoryInterface->getById($product->id);

            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($product), 'Success get product by ID', 200);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $productRequest = [
            'name' => $request->name,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
        ];

        DB::beginTransaction();

        try {
            $productResponse = $this->productRepositoryInterface->update($productRequest, $product->id);

            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($productResponse), 'Update product successfully', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            $this->productRepositoryInterface->delete($product->id);

            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($product->id), 'Delete product successfully', 204);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    public function search(Request $request)
    {
        $filters = $request->only(['name', 'category_id']);

        DB::beginTransaction();

        try {
            $products = $this->productRepositoryInterface->search($filters);

            DB::commit();
            return ApiResponseClass::sendResponse(ProductResource::collection($products), 'Success search product', 200);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    public function updateStock(UpdateStockProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepositoryInterface->updateStock(
                $request->product_id,
                $request->quantity,
            );

            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($product), 'Stock updated successfully', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    public function getTotalInventoryValue()
    {
        DB::beginTransaction();

        try {
            $totalValue = $this->productRepositoryInterface->getTotalInventoryValue();

            DB::commit();
            return ApiResponseClass::sendResponse(['total_value' => number_format($totalValue, 2)], 'Success get total value inventory', 200);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }
}
