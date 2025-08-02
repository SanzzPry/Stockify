<?php

namespace App\Repositories\Category;

use App\Models\Categories;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Events\ActivityLogged;
use Illuminate\Support\Facades\Auth;

class CategoryRepositoryImplement extends Eloquent implements CategoryRepository
{

    protected $model;

    public function __construct(Categories $model)
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
        $category = $this->model->create($data);

        event(new ActivityLogged(
            activity: 'Menambahkan kategori ' . $category->name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $category;
    }

    public function update($id, $data)
    {
        $category = $this->model->find($id);
        $category->update($data);

        event(new ActivityLogged(
            activity: 'Memperbarui kategori ' . $category->name,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $category;
    }

    public function delete($id)
    {
        $category = $this->model->find($id);
        $deletedName = $category->name;
        $result = $category->delete();

        event(new ActivityLogged(
            activity: 'Menghapus kategori ' . $deletedName,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $result;
    }
}
