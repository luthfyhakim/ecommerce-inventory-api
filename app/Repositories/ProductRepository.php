<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function index()
    {
        return Product::all();
    }

    public function getById($id)
    {
        return Product::findOrFail($id);
    }

    public function store(array $data)
    {
        return Product::create($data);
    }

    public function update(array $data, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product->load('category');
    }

    public function delete($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $product->delete();
    }

    public function search(array $filters)
    {
        $query = Product::with('category');

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->get();
    }

    public function updateStock($id, $quantity)
    {
        $product = Product::find($id);
        $product->stock_quantity = $quantity;
        $product->save();
        return $product->load('category');
    }

    public function getTotalInventoryValue()
    {
        return Product::selectRaw('SUM(price * stock_quantity) as total_value')
            ->first()
            ->total_value ?? 0;
    }
}
