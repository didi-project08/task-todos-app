<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/task-todos';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            $this->loadModuleRoutes();
        });
    }

    protected function loadModuleRoutes()
    {
        $modules_path = app_path('Modules');
        
        if (!file_exists($modules_path)) {
            return;
        }

        $modules = scandir($modules_path);
        
        foreach ($modules as $module) {
            if ($module === '.' || $module === '..') {
                continue;
            }

            $routerPath = $modules_path . "/{$module}/router.php";
            
            if (file_exists($routerPath)) {
                Route::middleware('web')
                    ->group($routerPath);
            }
        }
    }
}
