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
}
