<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'slug',
        'parent_id',
        'level',
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
public function children()
{
    return $this->hasMany(Category::class, 'parent_id');
}

    
    public function parent()
{
    return $this->belongsTo(Category::class, 'parent_id');
}

public function fullPath(): string
{
    $names = [];
    $category = $this;

    while ($category) {
        $names[] = $category->name;
        $category = $category->parent;
    }

    return implode(' / ', array_reverse($names));
}


}
