<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('github_id')
                ->nullable()
                ->unique();
        });
    }

    public function down(): void
    {
        if(isLocal()){
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['github_id']);
                $table->dropColumn('github_id');

            });
        }
    }
};
