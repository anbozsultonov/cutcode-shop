<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $thumbnail
 * */

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Brand $brand): void {
            if (!$brand->slug) {
                $brand->slug = str($brand->title)->slug();
            }
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
