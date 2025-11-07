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

    protected $fillable = ['name_market', 'location', 'status']; // sesuaikan kolom yang ada di tabel markets

    public function users()
    {
        return $this->hasMany(User::class, 'market_id');
    }
}
