<?php

namespace App\Providers;

ini_set('memory_limit', '-1');

use App\Models\BusinessSetting;
use App\Services\ReportCompanySettingsService;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // You can bind services here if needed.
        // Example:
        // $this->app->singleton(ReportCompanySettingsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // =========================
        // Load Migrations from Subdirectories
        // =========================
        $this->loadMigrationsFrom(glob(database_path('migrations/*'), GLOB_ONLYDIR));

        // =========================
        // Global: reportCompany (View Composer)
        // =========================
        View::composer('*', function ($view) {
            $view->with('reportCompany', app(ReportCompanySettingsService::class)->get());
        });

        // =========================
        // Pagination (Bootstrap)
        // =========================
        Paginator::useBootstrap();

        // =========================
        // Carbon Locale
        // =========================
        Carbon::setLocale('ar');

        // =========================
        // Anonymous Components Path
        // resources/views/admin-views/components
        // Usage: <x-admin-views::component-name />
        // =========================
        Blade::anonymousComponentPath(
            resource_path('views/admin-views/components'),
            'admin-views'
        );

        // =========================
        // Timezone from Business Setting (Safe)
        // =========================
        try {
            // avoid issues if DB not ready (migrations, cache, etc.)
            if (!\Schema::hasTable('business_settings')) {
                return;
            }

            $timezone = BusinessSetting::where('key', 'time_zone')->value('value');

            if (!empty($timezone)) {
                config(['app.timezone' => $timezone]);
                date_default_timezone_set($timezone);
            }
        } catch (\Throwable $e) {
            // optional: log error
            // \Log::error("Timezone boot error: ".$e->getMessage());
        }
    }
}
