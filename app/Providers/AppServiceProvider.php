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
    public function register()
    {
        //
    }


    public function boot()
    {
        Model::shouldBeStrict(isLocal());

        DB::listen(function ($query) {
            if ($query->time > 1000) {
                tgLog(
                    "url = " . request()?->url()
                    . 'query = ' . $query->sql
                    . 'bindings = ' . implode(', ', $query->bindings)
                );
            }
        });

        $kernel = app(Kernel::class);

        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(100),
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
