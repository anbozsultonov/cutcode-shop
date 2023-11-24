<?php

namespace App\Traits\Models;

use App\Models\ModelHasSlug;
use Illuminate\Support\Facades\DB;


trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function (ModelHasSlug $model): void {
            if (!$model->slug) {
                $model->generateSlug();
            }
        });
    }

    public function slugFrom(): string
    {
        return $this->title;
    }

    public function generateSlug(): void
    {
        $slug = str($this->slugFrom())->slug();

        check:
        if ($this->slugExists($slug)) {
            $slug .= "_1";
            goto check;
        }

        $this->slug = $slug;
    }

    public function slugExists(string $slug): bool
    {
        return DB::table($this->getTable())
            ->where('slug', '=', $slug)
            ->exists();
    }
}
