<?php

namespace Database\Factories;

use Database\Factories\Traits\HasFile;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;
use function PHPUnit\Framework\directoryExists;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    use HasFile;

    #[ArrayShape([
        'title' => "string",
        'thumbnail' => "string"
    ])]
    public function definition(): array
    {
        $testFolder = base_path('/tests/Fixtures/images/brands');
        $storageFolder = $this->getStorageImagesPath();

        return [
            'title' => $this->faker->company(),
            'thumbnail' => $this->faker->file(
                $testFolder,
                $storageFolder,
                false
            )
        ];
    }
}
