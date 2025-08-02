<?php

use App\Models\Categories;
use App\Models\ProductAttributes;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductAttributesController;
use App\Http\Controllers\StockTransactionsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::name('practice.')->group(function () {
//     Route::name('first')->get('practice/1', function () {
//         return view('pages.practice.1');
//     });
//     Route::name('second')->get('practice/2', function () {
//         return view('pages.practice.2');
//     });
// });


Route::get('/', [DashboardController::class, 'redirectTo'])->middleware('auth')->name('index');


// Route::group(['middleware' => ['admin', 'manager']], function () {
//     Route::get('/export-pdf/type', [StockTransactionsController::class, 'exportByType'])->name('stock.exportByType');
//     Route::get('/export-pdf/filter', [StockTransactionsController::class, 'exportByFilter'])->name('stock.exportByFilter');
// });
// Admin

Route::group(['middleware' => 'admin'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::prefix('product')->group(function () {
            Route::get('/', [ProductsController::class, 'index'])->name('product.index');
            Route::post('/store', [ProductsController::class, 'store'])->name('product.store');
            Route::get('/{id}/edit', [ProductsController::class, 'show'])->name('product.show');
            Route::put('/{id}/update', [ProductsController::class, 'update'])->name('product.update');
            Route::delete('/{id}', [ProductsController::class, 'destroy'])->name('product.destroy');
            Route::post('/product/import', [ProductsController::class, 'importSpreadsheet'])->name('product.import');
            Route::get('/product/export', [ProductsController::class, 'exportSpreadsheet'])->name('product.export');
        });
        Route::prefix('product/category')->group(function () {
            Route::get('/all', [CategoriesController::class, 'index'])->name('category.index');
            Route::post('/store', [CategoriesController::class, 'store'])->name('category.store');
            Route::get('/{id}/edit', [CategoriesController::class, 'show'])->name('category.show');
            Route::put('/{id}/update', [CategoriesController::class, 'update'])->name('category.update');
            Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('category.destroy');
        });
        Route::prefix('product/attribute')->group(function () {
            Route::get('/all', [ProductAttributesController::class, 'index'])->name('attribute.index');
            Route::post('/store', [ProductAttributesController::class, 'store'])->name('attribute.store');
            Route::get('/{id}/edit', [ProductAttributesController::class, 'show'])->name('attribute.show');
            Route::put('/{id}/update', [ProductAttributesController::class, 'update'])->name('attribute.update');
            Route::delete('/{id}', [ProductAttributesController::class, 'destroy'])->name('attribute.destroy');
        });

        Route::prefix('stock')->group(function () {
            Route::get('transaction/history', [StockTransactionsController::class, 'index'])->name('stock.index');
            Route::get('opname', [StockTransactionsController::class, 'opnameStockAdmin'])->name('opname.index');
            Route::get('/export-pdf/type', [StockTransactionsController::class, 'exportByType'])->name('stock.exportByType');
            Route::get('/export-pdf/filter', [StockTransactionsController::class, 'exportByFilter'])->name('stock.exportByFilter');
        });
        Route::resource('supplier', SuppliersController::class);
        Route::resource('user', UserController::class);
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::put('/setting/update', [SettingController::class, 'update'])->name('setting.update');
        Route::get('/users/activity-log/pdf', [UserController::class, 'activityLogPdf'])->name('activity.download');
    });
});


// manager
Route::group(['middleware' => 'manager'], function () {

    Route::prefix('manager')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');

        Route::prefix('product')->group(function () {
            Route::get('/', [ProductsController::class, 'manager'])->name('product.manager');
            Route::get('/{id}', [ProductsController::class, 'showManager'])->name('product.show.manager');
        });
        Route::prefix('supplier')->group(function () {
            Route::get('/all', [SuppliersController::class, 'showManager'])->name('supplier.show.manager');
        });
        Route::prefix('stock')->group(function () {
            Route::get('/transaction', [StockTransactionsController::class, 'Transaction'])->name('stock.manager');
            Route::get('/transaction/create', [StockTransactionsController::class, 'create'])->name('stock.create');
            Route::post('/transaction/create/store', [StockTransactionsController::class, 'store'])->name('stock.store');
            Route::get('opname', [StockTransactionsController::class, 'opnameStockManager'])->name('opname.manager');
            Route::post('update/minimum-stock', [StockTransactionsController::class, 'updateMinimumStock'])->name('stock.update');
            Route::get('/export-pdf/type', [StockTransactionsController::class, 'exportByType'])->name('stock.exportByType.manager');
            Route::get('/export-pdf/filter', [StockTransactionsController::class, 'exportByFilter'])->name('stock.exportByFilter.manager');
        });
    });
});

Route::group(['middleware' => 'staff'], function () {
    Route::prefix('staff')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');

        Route::prefix('stock')->group(function () {
            Route::get('/check', [StockTransactionsController::class, 'stockViewStaff'])->name('stock.staff');
            Route::post('/check/confirmation/{id}', [StockTransactionsController::class, 'confirmationStock'])->name('stock.confirmation');
        });
    });
});
require __DIR__ . '/auth.php';
