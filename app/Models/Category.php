<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @property int $id
 * @property string $title
 * @property string|null $thumbnail
 **/


class Category extends Model implements ModelHasSlug
{
    use HasFactory;
    use HasSlug;

    protected $table = 'categories';

    protected $fillable = [
        'slug',
        'title',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
