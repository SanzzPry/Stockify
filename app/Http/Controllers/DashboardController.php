<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use App\Services\Product\ProductService;
use App\Services\StockTransaction\StockTransactionService;
use App\Services\Supplier\SupplierService;

class DashboardController extends Controller
{
    //
    protected $productService, $stockTransactionService, $userService, $supplierService;

    public function __construct(
        ProductService $productService,
        StockTransactionService $stockTransactionService,
        UserService $userService,
        SupplierService $supplierService,
    ) {
        $this->productService = $productService;
        $this->stockTransactionService = $stockTransactionService;
        $this->userService = $userService;
        $this->supplierService = $supplierService;
    }

    public function redirectTo()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'Admin') {
                return redirect('admin/dashboard');
            } elseif (Auth::user()->role == "Manager Gudang") {
                return redirect('manager/dashboard');
            } elseif (Auth::user()->role == "Staff Gudang") {
                return redirect('staff/dashboard');
            }
        }

        return redirect(route('login'));
    }

    public function index()
    {
        $activities = $this->userService->getActivities();
        $getAllProducts = $this->productService->countAllProducts();
        $getAllSuppliers = $this->supplierService->getAllSupplier();
        $getAllStock = $this->stockTransactionService->getAllStockTransaction();
        $incomingTransaction = $this->stockTransactionService->getTransactionByTypeAndPeriod('Masuk', 1);
        $outgoingTransaction = $this->stockTransactionService->getTransactionByTypeAndPeriod('Keluar', 1);
        $incomingTransactionInMonth = $this->stockTransactionService->getTransactionByTypeAndPeriod('Masuk', 30);
        $outgoingTransactionInMonth = $this->stockTransactionService->getTransactionByTypeAndPeriod('Keluar', 30);
        $stockLastSixMonth = $this->stockTransactionService->getTransactionByLastSixMonths();
        $IncomingTransaction = $this->stockTransactionService->getTransactionByType('Masuk', 'Pending');
        $OutgoingTransaction = $this->stockTransactionService->getTransactionByType('Keluar', 'Pending');
        $minimumStock = $this->stockTransactionService->getMinimumQuantityStock();

        $lowStock = $getAllStock->filter(function ($stock) use ($minimumStock) {
            return $stock->quantity < $minimumStock || $stock->quantity == $minimumStock;
        })->count();

        if (Auth::user()->role == 'Admin') {
            return view('pages.admin.index', [
                'activity' => $activities,
                'totalProduct' => $getAllProducts,
                'totalSupplier' => count($getAllSuppliers),
                'incomingTransaction' => $incomingTransactionInMonth,
                'outgoingTransaction' => $outgoingTransactionInMonth,
                'transactionData' => $stockLastSixMonth,

            ]);
        } elseif (Auth::user()->role == "Manager Gudang") {
            return view('pages.manager.index', [
                'incomingStock' => $incomingTransaction,
                'outgoingStock' => $outgoingTransaction,
                'lowStock' => $lowStock,
            ]);
        } elseif (Auth::user()->role == "Staff Gudang") {
            return view('pages.staff.index', [
                'incomingItem' => count($IncomingTransaction),
                'outgoingItem' => count($OutgoingTransaction),
            ]);
        }
    }
}
