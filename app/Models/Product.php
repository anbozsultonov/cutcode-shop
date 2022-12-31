<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @property int $id
 * @property int $brand_id
 * @property int $price
 * @property string $title
 * @property string|null $thumbnail
 **/
class Product extends Model implements ModelHasSlug
{
    use HasFactory;
    use HasSlug;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'brand_id',
        'slug',
        'price',
        'thumbnail'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

}
