<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $thumbnail
 * */


class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'slug',
        'title',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Category $category): void {
            if (!$category->slug) {
                $category->slug = str($category->title)->slug();
            }
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
