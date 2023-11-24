<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
 * @property bool $on_home_page
 * @property int $sorting
 * @method Builder homePage()
 * @method static Builder|Product query()
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
        'thumbnail',
        'on_home_page',
        'sorting',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeHomePage(Builder $builder)
    {
        $builder->where('on_home_page', '=', true)
            ->orderBy('sorting')
            ->limit(6);
    }

}
