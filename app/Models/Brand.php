<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property string|null $thumbnail
 * @property bool $on_home_page
 * @property int $sorting
 * @method Builder homePage()
 * @method static Builder|Brand query()
 * */

class Brand extends Model implements ModelHasSlug
{
    use HasFactory;
    use HasSlug;

    protected $table = 'brands';

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_home_page',
        'sorting',
    ];

    public function scopeHomePage(Builder $builder)
    {
        $builder->where('on_home_page', '=', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
