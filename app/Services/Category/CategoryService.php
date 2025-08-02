<?php

namespace App\Services\Category;

use LaravelEasyRepository\BaseService;

interface CategoryService extends BaseService
{

    public function getAllCategory();
    public function findCategory($id);
    public function createCategory($data);
    public function updateCategory($id, $data);
    public function deleteCategory($id);
    // Write something awesome :)
}
