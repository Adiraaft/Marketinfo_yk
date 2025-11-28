<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';
    protected $primaryKey = 'id_price';

    protected $fillable = [
        'commodity_id',
        'user_id',
        'market_id',
        'price',
        'created_at',
        'updated_at',
        'date'
    ];

    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'commodity_id', 'id_commodity');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }
    public function commodityMarket()
    {
        return $this->belongsTo(CommodityMarket::class, 'commodity_id', 'commodity_id');
    }
}
