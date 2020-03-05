<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function scopeParentCategories($query)
    {
        return $query->whereNull('parent_category_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'id');
    }

    public function subCategories() 
    {
        return $this->categories()->get();
    }

    public function hasSubCategories()
    {
        return $this->categories()->count();
    }

    public function isParentCategory()
    {
        return is_null($this->parent_category_id);
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }
}
