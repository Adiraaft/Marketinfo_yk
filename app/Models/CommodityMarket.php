<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommodityMarket extends Model
{
    protected $table = 'commodity_market';

    protected $fillable = [
        'commodity_id',
        'market_id',
        'status'
    ];
    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'commodity_id', 'id_commodity');
    }

    public function market()
    {
        return $this->belongsTo(Market::class, 'market_id', 'id_market');
    }
}
