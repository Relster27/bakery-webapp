<?php

namespace App\Providers;

use App\Support\SafeFilesystem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('files', fn () => new SafeFilesystem());
        $this->app->alias('files', SafeFilesystem::class);

        $compiledViewPath = storage_path('framework/compiled-views');

        if (! is_dir($compiledViewPath)) {
            mkdir($compiledViewPath, 0777, true);
        }

        $this->app['config']->set('view.compiled', $compiledViewPath);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
