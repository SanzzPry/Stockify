<?php

namespace App\Repositories\StockTransaction;

use LaravelEasyRepository\Repository;

interface StockTransactionRepository extends Repository
{

    public function all();
    public function find($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function countTransactionByTypeAndPeriod($type, $days);
    public function transactionByMonthAndYear($type);
    public function transactionByLastSixMonths($type);
    public function filterByType($type, $status);
    public function getMinimumStock();
    public function updateMinimumStock($minQuantity);
    public function filterTransactions($type, $categoryId, $startDate, $endDate);


    // Write something awesome :)
}
