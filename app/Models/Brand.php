<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property string|null $thumbnail
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
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
