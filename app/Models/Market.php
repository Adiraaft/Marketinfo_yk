<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $table = 'markets';
    protected $primaryKey = 'id_market';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name_market',
        'address',
        'description',
        'opening_hours',
        'maps_link',
        'status',
        'image',
    ]; // sesuaikan kolom yang ada di tabel markets

    public function users()
    {
        return $this->hasMany(User::class, 'market_id');
    }
    public function commodities()
    {
        return $this->belongsToMany(Commodity::class, 'commodity_markets', 'market_id', 'commodity_id', 'id_market', 'id_commodity')
            ->withPivot('id', 'status', 'price')
            ->withTimestamps();
    }
    public function commodityMarkets()
    {
        return $this->hasMany(CommodityMarket::class, 'market_id');
    }
}
