<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Services\Product\ProductService;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        $category = $this->productService->getAllCategories();
        $supplier = $this->productService->getAllSuppliers();

        return view('pages.admin.product.index', [

            'products' => $products,
            'category' => $category,
            'supplier' => $supplier,
        ]);
    }

    public function manager()
    {
        $products = $this->productService->getAllProducts();
        $category = $this->productService->getAllCategories();
        $supplier = $this->productService->getAllSuppliers();

        return view('pages.manager.product.index',  [
            'products' => $products,
            'category' => $category,
            'supplier' => $supplier,
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
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/products', 'public');
        }

        $this->productService->createProduct($data);

        return redirect()->route('product.index')->with('success', 'Product data created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products, $id)
    {
        $products = $this->productService->getProduct($id);
        $category = $this->productService->getAllCategories();
        $supplier = $this->productService->getAllSuppliers();

        return view('pages.admin.product.product-edit', [
            'product' => $products,
            'category' => $category,
            'supplier' => $supplier,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function showManager(Products $products, $id)
    {
        $products = $this->productService->getProduct($id);
        return view('pages.manager.product.detail-product', [
            'product' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productService->updateProduct($id, $data);

        return redirect()->route('product.index')->with('success', 'updating category data was successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->productService->deleteProduct($id);

        return redirect()->route('product.index')->with('success', 'delete product data successfully');
    }

    public function importSpreadsheet(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,csv',
        ]);

        $importedData = (new FastExcel)->import($request->file('import_file'));

        if ($importedData->isEmpty()) {
            return redirect()->back()->with('error', 'The imported file is empty or invalid.');
        }

        $this->productService->importFromExcel($importedData);

        return redirect()->route('product.index')->with('success', 'Product imported successfully.');
    }
    public function exportSpreadsheet()
    {
        return $this->productService->exportToExcel();
    }
}
