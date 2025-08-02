<?php

namespace App\Services\Category;

use LaravelEasyRepository\Service;
use App\Repositories\Category\CategoryRepository;

class CategoryServiceImplement extends Service implements CategoryService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(CategoryRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function getAllCategory()
    {
        return $this->mainRepository->all();
    }
    public function findCategory($id)
    {
        return $this->mainRepository->find($id);
    }
    public function createCategory($data)
    {
        return $this->mainRepository->create($data);
    }
    public function updateCategory($id, $data)
    {
        return $this->mainRepository->update($id, $data);
    }
    public function deleteCategory($id)
    {
        return $this->mainRepository->delete($id);
    }

    // Define your custom methods :)
}
