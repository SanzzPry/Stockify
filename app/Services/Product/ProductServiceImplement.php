<?php

namespace App\Services\Product;

use LaravelEasyRepository\Service;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Supplier\SupplierRepository;
use Rap2hpoutre\FastExcel\FastExcel;


class ProductServiceImplement extends Service implements ProductService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;
    protected $categoryRepository;
    protected $supplierRepository;

    public function __construct(
        ProductRepository $mainRepository,
        CategoryRepository $categoryRepository,
        SupplierRepository $supplierRepository
    ) {
        $this->mainRepository = $mainRepository;
        $this->categoryRepository = $categoryRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function getAllProducts()
    {
        return $this->mainRepository->withRelation()->get();
    }

    public function countAllProducts()
    {
        return $this->mainRepository->count();
    }


    public function getProduct($id)
    {
        return $this->mainRepository->find($id);
    }

    public function createProduct($data)
    {
        return $this->mainRepository->create($data);
    }

    public function updateProduct($id, $data)
    {
        return $this->mainRepository->update($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->mainRepository->delete($id);
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->all();
    }

    public function getAllSuppliers()
    {
        return $this->supplierRepository->all();
    }


    public function exportToExcel()
    {
        $products = $this->mainRepository->all(); // sesuaikan jika ada method khusus
        return (new FastExcel($products))->download('products.xlsx');
    }

    public function importFromExcel($collection)
    {
        foreach ($collection as $row) {
            $data = [
                'category_id'     => $row['category_id'],
                'supplier_id'     => $row['supplier_id'],
                'name'            => $row['name'],
                'sku'             => $row['sku'],
                'description'     => $row['description'],
                'purchase_price'  => $row['purchase_price'],
                'selling_price'   => $row['selling_price'],
                'image'           => null, // bisa dikosongkan atau default
            ];

            $this->mainRepository->create($data);
        }
    }


    // public function importFromExcel($file) {
    //   (new FastExcel)->import($file, function($line) {
    //     $this->mainRepository->create([
    //       'category_id' => $line['category_id'],
    //       'supplier_id' => $line['supplier_id'],
    //       'name' => $line['name'],
    //       'sku' => $line['sku'],
    //       'description' => $line['description'],
    //       'purchase_price' => $line['purchase_price'],
    //       'selling_price' => $line['selling_price'],
    //       'image' => $line['image'],
    //     ]);
    //   });
    // }

    // public function exportFromExcel() {
    //   $model = $this->mainRepository->all();

    //   $data = $model->map(function($item) {
    //     return [
    //       'Category' => $item->categories->name,
    //       'Supplier' => $item->suppliers->name,
    //       'Name' => $item->name,
    //       'Stock Keeping Unit' => $item->sku,
    //       'Description' => $item->description,
    //       'Purchase Price' => $item->purchase_price,
    //       'Selling Price' => $item->selling_price,
    //       'Image' => $item->image,
    //     ];
    //   });

    //   return (new FastExcel($data))->download('product-list.xlsx');
    // }

    // Define your custom methods :)
}
