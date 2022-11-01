<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(!app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());

        DB::whenQueryingForLongerThan(100, function (Connection $connection): void {
            Log::channel('telegram')
                ->debug("whenQueryingForLongerThan || query = "
                    . $connection->query()->toSql()
                    . "|| route = "
                    . request()?->url()
                );
        });

        $kernel = app(Kernel::class);

        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(4),
            function (): void {
                Log::channel('telegram')
                    ->debug("whenRequestLifecycleIsLongerThan "
                        . "route = "
                        . request()?->url()
                    );
            }
        );
    }
}
