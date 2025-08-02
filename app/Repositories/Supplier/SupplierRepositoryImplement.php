<?php

namespace App\Repositories\Supplier;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Suppliers;
use App\Events\ActivityLogged;
use Illuminate\Support\Facades\Auth;

class SupplierRepositoryImplement extends Eloquent implements SupplierRepository
{
    protected $model;

    public function __construct(Suppliers $model)
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
        $supplier = $this->model->create($data);

        event(new ActivityLogged(
            activity: 'Menambahkan supplier: ' . $supplier->name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $supplier;
    }

    public function update($id, $data)
    {
        $supplier = $this->find($id);
        $supplier->update($data);

        event(new ActivityLogged(
            activity: 'Memperbarui supplier: ' . $supplier->name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $supplier;
    }

    public function delete($id)
    {
        $supplier = $this->find($id);
        $name = $supplier->name;
        $result = $supplier->delete();

        event(new ActivityLogged(
            activity: 'Menghapus supplier: ' . $name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $result;
    }
}
