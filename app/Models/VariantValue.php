<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantValue extends Model
{
    protected $table = 'variant_value';

    protected $fillable = [
        'variant_id',
        'value_id',
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function value()
    {
        return $this->belongsTo(AttributeValue::class, 'value_id');
    }
}
