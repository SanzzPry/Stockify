<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributes;
use App\Services\ProductAttribute\ProductAttributeService;
use Illuminate\Http\Request;

class ProductAttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $productAttributeService;

    public function __construct(ProductAttributeService $productAttributeService)
    {
        $this->productAttributeService = $productAttributeService;
    }
    public function index()
    {
        $productAttributes = $this->productAttributeService->getAllProductAttribute();
        $products = $this->productAttributeService->getAllProducts();
        return view('pages.admin.product.attribute.index', [
            'productAttribute' => $productAttributes,
            'product' => $products,
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
            'product_id' => 'required|exists:products,id',
            'name' => 'required',
            'value' => 'required',
        ]);

        $this->productAttributeService->createProductattribute($data);

        return redirect()->route('attribute.index')->with('succes', 'product attribute data created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $productAttibutes = $this->productAttributeService->findProductAttribute($id);
        $products = $this->productAttributeService->getAllProducts();
        return view('pages.admin.product.attribute.attribute-edit', [
            'product' => $products,
            'productAttribute' => $productAttibutes,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required',
            'value' => 'required',
        ]);

        $this->productAttributeService->updateProductAttribute($id, $data);

        return redirect()->route('attribute.index')->with('succes', 'updating product attribute data was successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->productAttributeService->deleteProductAttribute($id);

        return redirect()->route('attribute.index')->with('succes', 'delete product attribute data successfully');
    }
}
