<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'default',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_value', 'variant_id', 'value_id')
                    ->withTimestamps();
    }
}
