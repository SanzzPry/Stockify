<?php

namespace App\Repositories\Product;

use App\Models\Products;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Events\ActivityLogged;
use Illuminate\Support\Facades\Auth;

class ProductRepositoryImplement extends Eloquent implements ProductRepository
{
    protected $model;

    public function __construct(Products $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function count()
    {
        return $this->model->count();
    }

    public function withRelation()
    {
        return $this->model->with(['categories', 'suppliers']);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($data)
    {
        $product = $this->model->create($data);

        event(new ActivityLogged(
            activity: 'Menambahkan produk ' . $product->name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $product;
    }

    public function update($id, $data)
    {
        $product = $this->model->find($id);
        $product->update($data);

        event(new ActivityLogged(
            activity: 'Memperbarui produk ' . $product->name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $product;
    }

    public function delete($id)
    {
        $product = $this->model->find($id);
        $deletedName = $product->name;
        $result = $product->delete();

        event(new ActivityLogged(
            activity: 'Menghapus produk ' . $deletedName,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $result;
    }
}
