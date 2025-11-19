<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $table = 'commodities';
    protected $primaryKey = 'id_commodity';
    public $incrementing = true;

    protected $fillable = [
        'name_commodity',
        'category_id',
        'unit_id',
        'status',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
     public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }
}
