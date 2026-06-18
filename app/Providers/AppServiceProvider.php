<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        if (env('VERCEL')) {
            // Re-route storage paths to /tmp since Vercel Lambda is read-only
            $tmpPath = '/tmp/storage';
            
            if (!is_dir($tmpPath)) {
                mkdir($tmpPath, 0755, true);
                mkdir($tmpPath . '/views', 0755, true);
                mkdir($tmpPath . '/sessions', 0755, true);
                mkdir($tmpPath . '/cache', 0755, true);
            }

            config([
                'view.compiled' => $tmpPath . '/views',
                'session.files' => $tmpPath . '/sessions',
                'cache.stores.file.path' => $tmpPath . '/cache',
            ]);
        }
    }
}
