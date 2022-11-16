<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @property int $id
 * @property int $brand_id
 * @property int $price
 * @property string $slug
 * @property string $title
 * @property string|null $thumbnail
 **/
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'brand_id',
        'slug',
        'price',
        'thumbnail'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product): void {
            if (!$product->slug) {
                $product->slug = str($product->title)->slug();
            }
        });
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

}
