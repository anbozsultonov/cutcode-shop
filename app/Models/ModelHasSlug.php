<?php

namespace App\Models;

/**
 * @property string $slug
 * @method string getTable
 **/

interface ModelHasSlug
{
    public static function bootHasSlug(): void;

    public function slugFrom(): string;

    public function generateSlug(): void;

    public function slugExists(string $slug): bool;
}
