<?php

namespace App\Providers;

use App\View\Components\Icon;
use App\Services\User\UserService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use App\Services\Product\ProductService;
use App\Services\Setting\SettingService;
use App\Services\Category\CategoryService;
use App\Services\Supplier\SupplierService;
use App\Services\User\UserServiceImplement;
use App\Services\Product\ProductServiceImplement;
use App\Services\Setting\SettingServiceImplement;
use App\Services\Category\CategoryServiceImplement;
use App\Services\Supplier\SupplierServiceImplement;
use App\Services\ProductAttribute\ProductAttributeService;
use App\Services\StockTransaction\StockTransactionService;
use App\Services\ProductAttribute\ProductAttributeServiceImplement;
use App\Services\StockTransaction\StockTransactionServiceImplement;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryService::class, CategoryServiceImplement::class);
        $this->app->bind(ProductService::class, ProductServiceImplement::class);
        $this->app->bind(SupplierService::class, SupplierServiceImplement::class);
        $this->app->bind(ProductAttributeService::class, ProductAttributeServiceImplement::class);
        $this->app->bind(SettingService::class, SettingServiceImplement::class);
        $this->app->bind(StockTransactionService::class, StockTransactionServiceImplement::class);
        $this->app->bind(UserService::class, UserServiceImplement::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade::componentNamespace('BladeUI\\Heroicons\\Components', 'heroicon');
    }
}
