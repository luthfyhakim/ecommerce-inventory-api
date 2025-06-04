<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function index();
    public function getById($id);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function search(array $filters);
    public function updateStock($id, $quantity);
    public function getTotalInventoryValue();
}
