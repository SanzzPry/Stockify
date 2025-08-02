<?php

namespace App\Services\StockTransaction;

use LaravelEasyRepository\Service;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Supplier\SupplierRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;

class StockTransactionServiceImplement extends Service implements StockTransactionService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;
    protected $categoryService;
    protected $supplierRepository;
    protected $productRepository;

    public function __construct(
        StockTransactionRepository $mainRepository,
        CategoryRepository $categoryRepository,
        SupplierRepository $supplierRepository,
        ProductRepository $productRepository,
    ) {
        $this->mainRepository = $mainRepository;
        $this->categoryService = $categoryRepository;
        $this->supplierRepository = $supplierRepository;
        $this->productRepository = $productRepository;
    }

    public function getAllStockTransaction()
    {
        return $this->mainRepository->all();
    }


    public function getTransactionByProduct($id)
    {
        return $this->mainRepository->find($id);
    }

    public function createTransaction($data)
    {
        return $this->mainRepository->create($data);
    }

    public function updateTransaction($id, $data)
    {
        return $this->mainRepository->update($id, $data);
    }

    public function deleteTransaction($id)
    {
        return $this->mainRepository->delete($id);
    }

    public function getAllCategoryById()
    {
        return $this->categoryService->all();
    }

    public function getAllSuppliersById()
    {
        return $this->supplierRepository->all();
    }

    public function getAllProductById()
    {
        return $this->productRepository->all();
    }

    public function getTransactionByTypeAndPeriod($type, $days = 30)
    {
        return $this->mainRepository->countTransactionByTypeAndPeriod($type, $days);
    }

    public function getTransactionByMonthAndYear()
    {
        $transactionIn = $this->mainRepository->transactionByMonthAndYear('masuk');
        $transactionOut = $this->mainRepository->transactionByMonthAndYear('keluar');

        return [
            'DataIn' => $transactionIn,
            'DataOut' => $transactionOut,
        ];
    }

    public function getTransactionByType($type, $status)
    {
        return $this->mainRepository->filterByType($type, $status);
    }
    public function getMinimumQuantityStock()
    {
        return $this->mainRepository->getMinimumStock();
    }

    public function updateMinimumQuantityStock($minQuantity)
    {
        if ($minQuantity < 0) {
            throw new \InvalidArgumentException('Minimum stock must be greater than or equal to zero.');
        }
        $this->mainRepository->updateMinimumStock($minQuantity);
    }

    public function getFilteredTransactions($type, $categoryId, $startDate, $endDate)
    {
        return $this->mainRepository->filterTransactions($type, $categoryId, $startDate, $endDate);
    }
    public function getTransactionByLastSixMonths()
    {
        $transactionIn = $this->mainRepository->transactionByMonthAndYear('masuk');
        $transactionOut = $this->mainRepository->transactionByMonthAndYear('keluar');

        return [
            'DataIn' => $transactionIn,
            'DataOut' => $transactionOut,
        ];
    }


    // Define your custom methods :)
}
