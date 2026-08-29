<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UniqueSlugService
{
    /**
     * @param  class-string<Model>  $modelClass
     */
    public function make(string $modelClass, string $title): string
    {
        $base = Str::slug($title) ?: 'item';
        $slug = $base;
        $counter = 2;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
