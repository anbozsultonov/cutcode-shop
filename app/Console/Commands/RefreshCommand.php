<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'refresh';


    protected $description = 'Refresh';


    public function handle(): int
    {
        if (isProduction()) {
            return self::FAILURE;
        }

        if (Storage::exists('/images')) {
            Storage::deleteDirectory('/images');
        }

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);

        return self::SUCCESS;
    }
}
