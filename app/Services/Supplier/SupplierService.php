<?php

namespace App\Services\Supplier;

use LaravelEasyRepository\BaseService;

interface SupplierService extends BaseService
{

    public function getAllSupplier();
    public function findSupplier($id);
    public function createSupplier($data);
    public function updateSupplier($id, $data);
    public function deleteSupplier($id);
    // Write something awesome :)
}
