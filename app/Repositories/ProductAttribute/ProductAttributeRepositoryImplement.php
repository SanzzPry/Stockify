<?php

namespace App\Repositories\ProductAttribute;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\ProductAttributes;
use App\Events\ActivityLogged;
use Illuminate\Support\Facades\Auth;

class ProductAttributeRepositoryImplement extends Eloquent implements ProductAttributeRepository
{
    protected $model;

    public function __construct(ProductAttributes $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($data)
    {
        $productAttributes = $this->model->create($data);

        event(new ActivityLogged(
            activity: 'Menambahkan atribut produk: ' . $productAttributes->name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $productAttributes;
    }

    public function update($id, $data)
    {
        $productAttributes = $this->find($id);
        $productAttributes->update($data);

        event(new ActivityLogged(
            activity: 'Memperbarui atribut produk: ' . $productAttributes->name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $productAttributes;
    }

    public function delete($id)
    {
        $productAttributes = $this->find($id);
        $deletedName = $productAttributes->name;
        $result = $productAttributes->delete();

        event(new ActivityLogged(
            activity: 'Menghapus atribut produk: ' . $deletedName,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $result;
    }
}
