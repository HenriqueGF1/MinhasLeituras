<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Services\Api\Google\ApiGoogleBooks;
use App\Http\Services\Api\Google\IsbnApiInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** Register any application services. */
    public function register()
    {
        $this->app->bind(IsbnApiInterface::class, ApiGoogleBooks::class);
    }

    /** Bootstrap any application services. */
    public function boot(): void {}
}
