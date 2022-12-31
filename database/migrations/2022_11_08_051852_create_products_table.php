<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->string('slug')->unique();

            $table->string('thumbnail')
                ->nullable();

            $table->unsignedInteger('price')->default(0);

            $table->foreignIdFor(Brand::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Category::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (isLocal()) {
            Schema::table('category_product', function (Blueprint $table) {
                $table->dropForeign('category_product_category_id_foreign');
                $table->dropForeign('category_product_product_id_foreign');
            });
            Schema::dropIfExists('category_product');
            Schema::dropIfExists('products');

        }
    }
};
