<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $table = 'commodities';
    protected $primaryKey = 'id_commodity';
    public $timestamps = false;

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}


