<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    public function getImages()
    {
        return explode(',', str_replace("\\", "/", str_replace("]", '', str_replace("[", '', str_replace('"', '', $this->images)))));
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
