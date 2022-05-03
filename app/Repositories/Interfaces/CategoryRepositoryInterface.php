<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function createCategory(array $request);
    public function getCategoryById($category);
    public function updateCategory(array $request, $category);
    public function forceDeleteCategory($category);
}
