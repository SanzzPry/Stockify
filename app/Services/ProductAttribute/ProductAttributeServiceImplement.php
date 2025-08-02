<?php

namespace App\Services\ProductAttribute;

use App\Repositories\Product\ProductRepository;
use LaravelEasyRepository\Service;
use App\Repositories\ProductAttribute\ProductAttributeRepository;

use function PHPUnit\Framework\returnCallback;

class ProductAttributeServiceImplement extends Service implements ProductAttributeService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;
    protected $productRepository;

    public function __construct(
        ProductAttributeRepository $mainRepository,
        ProductRepository $productRepository
    ) {
        $this->mainRepository = $mainRepository;
        $this->productRepository = $productRepository;
    }

    public function getAllProductAttribute()
    {
        return $this->mainRepository->all();
    }
    public function getAllProducts()
    {
        return $this->productRepository->all();
    }
    public function findProductAttribute($id)
    {
        return $this->mainRepository->find($id);
    }
    public function createProductAttribute($data)
    {
        return $this->mainRepository->create($data);
    }
    public function updateProductAttribute($id, $data)
    {
        return $this->mainRepository->update($id, $data);
    }
    public function deleteProductAttribute($id)
    {
        return $this->mainRepository->delete($id);
    }

    // Define your custom methods :)
}
