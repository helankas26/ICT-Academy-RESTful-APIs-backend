<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getAllCategories()
    {
        // TODO: Implement getAllCategories() method.
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function createCategory(array $request)
    {
        // TODO: Implement createCategory() method.
    }

    /**
     * @param $category
     * @return mixed
     */
    public function getCategoryById($category)
    {
        // TODO: Implement getCategoryById() method.
    }

    /**
     * @param array $request
     * @param $category
     * @return mixed
     */
    public function updateCategory(array $request, $category)
    {
        // TODO: Implement updateCategory() method.
    }

    /**
     * @param $category
     * @return mixed
     */
    public function forceDeleteCategory($category)
    {
        // TODO: Implement forceDeleteCategory() method.
    }
}
