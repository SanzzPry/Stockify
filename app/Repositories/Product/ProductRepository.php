<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository
{

    public function all();
    public function withRelation();
    public function count();
    public function find($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);

    // Write something awesome :)
}
