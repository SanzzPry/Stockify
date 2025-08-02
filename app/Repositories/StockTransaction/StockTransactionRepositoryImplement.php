<?php

namespace App\Repositories\StockTransaction;

use App\Events\ActivityLogged;
use App\Models\StockTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use LaravelEasyRepository\Implementations\Eloquent;

class StockTransactionRepositoryImplement extends Eloquent implements StockTransactionRepository
{
    protected $model;

    public function __construct(StockTransactions $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with(['products', 'users'])->get();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($data)
    {
        $transaction = $this->model->create($data);

        event(new ActivityLogged(
            activity: 'Menambahkan transaksi stok: ' . $transaction->type . ' (ID #' . $transaction->id . ')',
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $transaction;
    }

    public function update($id, $data)
    {
        $transaction = $this->model->find($id);
        $transaction->update($data);

        event(new ActivityLogged(
            activity: 'Memperbarui transaksi stok: ' . $transaction->type . ' (ID #' . $transaction->id . ')',
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $transaction;
    }

    public function delete($id)
    {
        $transaction = $this->model->find($id);
        $deletedInfo = $transaction->type . ' (ID #' . $transaction->id . ')';
        $result = $transaction->delete();

        event(new ActivityLogged(
            activity: 'Menghapus transaksi stok: ' . $deletedInfo,
            user: Auth::user()?->name ?? 'Guest',
            role: Auth::user()?->role ?? 'unknown'
        ));

        return $result;
    }

    public function countTransactionByTypeAndPeriod($type, $days = 30)
    {
        $startDate = now()->subDays($days)->startOfDay();
        $endDate = now()->endOfDay();

        return $this->model
            ->where('type', $type)
            ->whereBetween('date', [$startDate, $endDate])
            ->count();
    }

    public function transactionByMonthAndYear($type)
    {
        return $this->model->selectRaw('MONTH(date) as month, YEAR(date) as year, SUM(quantity) as total_quantity')
            ->where('type', $type)
            ->groupBy('month', 'year')
            ->orderByRaw('year, month')
            ->get();
    }

    public function transactionByLastSixMonths($type)
    {
        // $sixMonthsAgo = now()->subMonths(5)->startOfMonth(); // 6 bulan termasuk bulan ini
        // return $this->model->selectRaw('MONTH(date) as month, YEAR(date) as year, SUM(quantity) as total_quantity')
        //     ->where('type', $type)
        //     ->where('date', '>=', $sixMonthsAgo)
        //     ->groupBy('month', 'year')
        //     ->orderByRaw('year, month')
        //     ->get();

        $vita = $this->model->selectRaw('MONTH(date) as month, YEAR(DATE) as year, SUM(quantity) as total_quantity')
            ->where('type', $type)
            ->groupBy('month', 'year')
            ->orderByRaw('year, month')
            ->get();

        return $vita;
    }


    public function filterByType($type, $status = null)
    {
        $query = $this->model->where('type', $type);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->with(['products', 'users'])->get();
    }

    public function getMinimumStock()
    {
        return config('stock.minimum_stock');
    }

    public function updateMinimumStock($minQuantity)
    {
        $path = config_path('stock.php');
        $content = file_get_contents($path);

        $replaceContent = preg_replace(
            "/'minimum_stock' => (\d+)/",
            "'minimum_stock' => {$minQuantity}",
            $content
        );

        file_put_contents($path, $replaceContent);

        Artisan::call('config:clear');
        Artisan::call('config:cache');
    }
    public function filterTransactions($type = null, $categoryId = null, $startDate = null, $endDate = null)
    {
        return StockTransactions::with('products')
            ->when($type, function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->whereHas('products', function ($p) use ($categoryId) {
                    $p->where('category_id', $categoryId);
                });
            })
            ->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            })
            ->orderByDesc('date')
            ->get();
    }
}
