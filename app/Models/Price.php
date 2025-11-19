<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';
    protected $primaryKey = 'id_price';
    protected $fillable = ['commodity_id', 'market_id', 'price'];

    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }
}
