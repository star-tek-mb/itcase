<?php


namespace App\Models\Components;

use Illuminate\Support\Str;

trait Slug
{
    /**
     * Generate slug
     *
     * @return void
     */
    public function generateSlug()
    {
        $slug = Str::slug($this->ru_title);
        $existCount = self::where('ru_slug', $slug)->count();
        if ($existCount > 0) {
            $slug .= "-$existCount";
        }
        $this->ru_slug = $slug;
        $this->save();
    }
}
