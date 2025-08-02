<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Services\Category\CategoryService;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $categories = $this->categoryService->getAllCategory();
        return view('pages.admin.category.index', [
            'category' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $this->categoryService->createCategory($data);

        return redirect()->route('category.index')->with('succes', 'category data created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categories = $this->categoryService->findCategory($id);
        return view('pages.admin.category.category-edit', [

            'category' => $categories,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $this->categoryService->updateCategory($id, $data);

        return redirect()->route('category.index')->with('succes', 'updating category data was successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);

        return redirect()->route('category.index')->with('succes', 'delete category data successfully');
    }
}
