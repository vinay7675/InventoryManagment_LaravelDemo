<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
//use Illuminate\Foundation\Support\Providers\AppServiceProvider as ServiceProvider;
// use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\Route;

// class AppServiceProvider extends ServiceProvider
// {
//     public function boot(): void
//     {
//         $this->routes(function () {
//             Route::middleware('api')
//                 ->prefix('api')
//                 ->group(base_path('routes/api.php'));

//             Route::middleware('web')
//                 ->group(base_path('routes/web.php'));
//         });
//     }
// }
