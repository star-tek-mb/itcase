<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class SlugHelper
{
    /**
     * @param $params
     * @return boolean
     */
    public static function checkSlug($params)
    {
        $paramsArray = explode('/', trim($params, '/'));
        $uniqueParamsArray = array_unique($paramsArray);
        if (count($paramsArray) != count($uniqueParamsArray)) {
            return false;
        }

        $allSlugs = \DB::table('blog_categories')
            ->union(\DB::table('blog_posts')->select(['ru_slug']))
            ->union(DB::table('companies')->select(['ru_slug']))
            ->union(DB::table('handbook_categories')->select(['ru_slug']))
            ->union(DB::table('menu_items')->select(['ru_slug']))
            ->get(['ru_slug']);
        foreach ($paramsArray as $param) {
            if (!$allSlugs->contains('ru_slug', $param)) {
                return false;
            }
        }
        return true;
    }
}
