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

        // 👉 ពេល run artisan / composer (runningInConsole) កុំ query DB ទេ
        if (app()->runningInConsole()) {
            return;
        }

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
            // ignore error ពេល DB មិនទាន់ ready
            // \Log::error($e->getMessage());
        }
    }
}
