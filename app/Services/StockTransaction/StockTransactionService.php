<?php

namespace App\Services\StockTransaction;

use LaravelEasyRepository\BaseService;

interface StockTransactionService extends BaseService
{

    public function getAllStockTransaction();
    public function getTransactionByProduct($id);
    public function createTransaction($data);
    public function updateTransaction($id, $data);
    public function deleteTransaction($id);
    public function getAllCategoryById();
    public function getAllSuppliersById();
    public function getAllProductById();
    public function getTransactionByTypeAndPeriod($type, $days);
    public function getTransactionByMonthAndYear();
    public function getTransactionByLastSixMonths();
    public function getTransactionByType($type, $status);
    public function getMinimumQuantityStock();
    public function updateMinimumQuantityStock($minQuantity);
    public function getFilteredTransactions($type, $categoryId, $startDate, $endDate);


    // Write something awesome :)
}
