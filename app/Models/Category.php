<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id_category';
    protected $keyType = 'int';
    public $timestamps = true; // karena tabel punya created_at & updated_at

    protected $fillable = [
        'name_category',
        'image', // ← tambahkan ini
    ];

    public function commodities()
    {
        // foreign key on commodities = category_id, local PK = id_category
        return $this->hasMany(Commodity::class, 'category_id', 'id_category');
    }
}
