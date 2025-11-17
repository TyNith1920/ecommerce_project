<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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

        // ✅ បន្ថែមការចែករំលែកអថេរទៅក្នុង view ទាំងអស់
        view()->share('user', User::count());
        view()->share('product', Product::count());
        view()->share('order', Order::count());
        view()->share('delivered', Order::where('status', 'Delivery')->count());
    }
}
