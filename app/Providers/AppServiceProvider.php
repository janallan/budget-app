<?php

namespace App\Providers;

use App\Enums\SalaryOptions;
use App\Enums\SalaryTypes;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        class_alias(SalaryTypes::class, 'SalaryTypes');
        class_alias(SalaryOptions::class, 'SalaryOptions');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
