<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // បើកំពុងរត់ command ក្នុង console (artisan) -> កុំ query DB
        if (app()->runningInConsole()) {
            return;
        }

        // ប៉ុន្តែបើចង់ប្រើក្នុង web ទេ​
        try {
            if (Schema::hasTable('users')) {
                view()->share('user', User::count());
            }

            if (Schema::hasTable('products')) {
                view()->share('product', Product::count());
            }

            if (Schema::hasTable('orders')) {
                view()->share('order', Order::count());
                view()->share(
                    'delivered',
                    Order::where('status', 'Delivery')->count()
                );
            }
        } catch (\Exception $e) {
            // អាច log បន្តិចក៏បាន ប៉ុន្តែមិនបាច់
            // \Log::error($e->getMessage());
        }
    }
}
