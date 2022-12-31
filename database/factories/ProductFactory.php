<?php

namespace Database\Factories;

use App\Models\Brand;
use Database\Factories\Traits\HasFile;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    use HasFile;

    public function definition(): array
    {
        $testFolder = base_path('/tests/Fixtures/images/products');
        $storageFolder = $this->getStorageImagesPath();

        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'thumbnail' => $this->faker->file(
                $testFolder,
                $storageFolder,
                false
            ),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'price' => $this->faker->numberBetween(1000, 100000),
        ];
    }
}
