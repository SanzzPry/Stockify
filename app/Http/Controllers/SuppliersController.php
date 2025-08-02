<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use Illuminate\Http\Request;
use App\Services\Supplier\SupplierService;

class SuppliersController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }
    public function index()
    {
        $suppliers = $this->supplierService->getAllsupplier();
        return view('pages.admin.supplier.index', [
            'supplier' => $suppliers,
        ]);
    }
    public function showManager()
    {
        $suppliers = $this->supplierService->getAllsupplier();
        return view('pages.manager.supplier.index', [
            'supplier' => $suppliers,
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
            'address' => 'nullable|string',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email',
        ]);

        $this->supplierService->createSupplier($data);

        return redirect()->route('supplier.index')->with('success', 'supplier data created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $suppliers = $this->supplierService->findSupplier($id);
        return view('pages.admin.supplier.supplier-edit', [

            'supplier' => $suppliers,
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
            'name' => 'required',
            'address' => 'nullable|string',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email',
        ]);

        $this->supplierService->updateSupplier($id, $data);

        return redirect()->route('supplier.index')->with('success', 'updating supplier data was successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->supplierService->deleteSupplier($id);

        return redirect()->route('supplier.index')->with('succes', 'delete supplier data successfully');
    }
}
