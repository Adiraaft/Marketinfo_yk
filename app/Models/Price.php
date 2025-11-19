<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';
    protected $primaryKey = 'id_price';
    public $timestamps = false;
    protected $fillable = [
        'commodity_id',
        'user_id',
        'market_id',
        'price',
        'created_at',
        'updated_at'
    ];

    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }
}
