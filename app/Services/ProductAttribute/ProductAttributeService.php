<?php

namespace App\Services\ProductAttribute;

use LaravelEasyRepository\BaseService;

interface ProductAttributeService extends BaseService
{

    public function getAllProductAttribute();
    public function getAllProducts();
    public function findProductAttribute($id);
    public function createProductAttribute($data);
    public function updateProductAttribute($id, $data);
    public function deleteProductAttribute($id);

    // Write something awesome :)
}
