<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StockTransactions;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use App\Services\StockTransaction\StockTransactionService;

class StockTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $stockTransactionService;

    public function __construct(StockTransactionService $stockTransactionService)
    {
        $this->stockTransactionService = $stockTransactionService;
    }
    public function index(Request $request)
    {
        $type = $request->input('type');
        $categoryId = $request->input('category_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $categories = $this->stockTransactionService->getAllCategoryById();
        $suppliers = $this->stockTransactionService->getAllSuppliersById();
        $products = $this->stockTransactionService->getAllProductById();

        $allTransactions = $this->stockTransactionService->getAllStockTransaction();

        $transactionsByType = $allTransactions->filter(function ($item) use ($type) {
            return !$type || $item->type === $type;
        });

        $transactionsByFilter = $allTransactions->filter(function ($item) use ($categoryId, $startDate, $endDate) {
            return (!$categoryId || $item->products?->category_id == $categoryId)
                && (!$startDate || $item->date >= $startDate)
                && (!$endDate || $item->date <= $endDate);
        });


        return view('pages.admin.stock.index', [
            'category' => $categories,
            'supplier' => $suppliers,
            'product' => $products,
            'transactionsByType' => $transactionsByType,
            'transactionsByFilter' => $transactionsByFilter,
            'type' => $type,
            'selectedCategory' => $categoryId,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }


    public function Transaction(Request $request)
    {
        $type = $request->input('type');
        $categoryId = $request->input('category_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $categories = $this->stockTransactionService->getAllCategoryById();
        $suppliers = $this->stockTransactionService->getAllSuppliersById();
        $products = $this->stockTransactionService->getAllProductById();

        $allTransactions = $this->stockTransactionService->getAllStockTransaction();

        $transactionsByType = $allTransactions->filter(function ($item) use ($type) {
            return !$type || $item->type === $type;
        });

        $transactionsByFilter = $allTransactions->filter(function ($item) use ($categoryId, $startDate, $endDate) {
            return (!$categoryId || $item->products?->category_id == $categoryId)
                && (!$startDate || $item->date >= $startDate)
                && (!$endDate || $item->date <= $endDate);
        });


        return view('pages.manager.stock.index', [
            'category' => $categories,
            'supplier' => $suppliers,
            'product' => $products,
            'transactionsByType' => $transactionsByType,
            'transactionsByFilter' => $transactionsByFilter,
            'type' => $type,
            'selectedCategory' => $categoryId,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
        // $categories = $this->stockTransactionService->getAllCategoryById();
        // $suppliers = $this->stockTransactionService->getAllSuppliersById();
        // $products  = $this->stockTransactionService->getAllProductById();
        // $transactions = $this->stockTransactionService->getAllStockTransaction();


        // return view('pages.manager.stock.index', [
        //     'category' => $categories,
        //     'supplier' => $suppliers,
        //     'product' => $products,
        //     'transaction' => $transactions,
        // ]);
    }

    public function opnameStockAdmin()
    {
        $minimumStock = $this->stockTransactionService->getMinimumQuantityStock();
        $stocks = $this->stockTransactionService->getAllStockTransaction();

        return view('pages.admin.stock.opname', [
            'stock' => $stocks,
            'minimumStock' => $minimumStock,
        ]);
    }

    public function opnameStockManager()
    {
        $stocks = $this->stockTransactionService->getAllStockTransaction();

        return view('pages.manager.stock.opname', [
            'stock' => $stocks,
        ]);
    }

    public function stockViewStaff()
    {
        $getAllStock = $this->stockTransactionService->getAllStockTransaction();
        $pendingStatus = $getAllStock->filter(function ($item) {
            return $item->status === 'Pending';
        });
        return view('pages.staff.stock.index', [
            'data' => $pendingStatus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->stockTransactionService->getAllCategoryById();
        $suppliers = $this->stockTransactionService->getAllSuppliersById();
        $products  = $this->stockTransactionService->getAllProductById();

        return view('pages.manager.stock.create-transaction', [
            'category' => $categories,
            'supplier' => $suppliers,
            'product' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:Masuk,Keluar',
            'quantity' => 'required|integer',
            'date' => 'nullable|date',
            'status' => 'required|in:Pending,Diterima,Ditolak,Dikeluarkan',
            'notes' => 'nullable|string',
        ]);
        $data['user_id'] = auth()->id();

        $this->stockTransactionService->createTransaction($data);


        return redirect()->route('stock.manager')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function confirmationStock(Request $request, $id)
    {
        $validate = $request->validate([
            'status' => 'required|in:Diterima,Ditolak,Dikeluarkan',
        ]);

        $stock = $this->stockTransactionService->getTransactionByProduct($id);
        $stock->status = $validate['status'];
        $stock->save();

        return redirect()->route('stock.staff')->with('success');
    }

    public function updateMinimumStock(Request $request)
    {
        $validated = $request->validate([
            'stock_minimum' => 'required|integer|min:0',
        ]);

        $this->stockTransactionService->updateMinimumQuantityStock($validated['stock_minimum']);
        return redirect()->back()->with('success', 'Stok minimum berhasil diperbarui.');
    }

    public function exportByType(Request $request)
    {
        $type = $request->input('type');
        $categoryId = $request->input('category_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = [
            'stocks' => $this->stockTransactionService->getFilteredTransactions($type, $categoryId, $startDate, $endDate),
            'type' => $type,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'category' => Categories::find($categoryId),
        ];

        $pdf = Pdf::loadView('pages.report.pdfbytype', $data)->setPaper('a4', 'landscape');
        return $pdf->download('laporan_stok_' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportByFilter(Request $request)
    {
        $type = null; // Tidak digunakan
        $categoryId = $request->input('category_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = [
            'stocks' => $this->stockTransactionService->getFilteredTransactions($type, $categoryId, $startDate, $endDate),
            'category' => Categories::find($categoryId),
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        $pdf = Pdf::loadView('pages.report.pdfbyfilter', $data)->setPaper('a4', 'landscape');
        return $pdf->download('laporan_stok_kategori_periode_' . now()->format('Ymd_His') . '.pdf');
    }





    /**
     * Display the specified resource.
     */
    public function show(StockTransactions $stockTransactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockTransactions $stockTransactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockTransactions $stockTransactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockTransactions $stockTransactions)
    {
        //
    }
}
