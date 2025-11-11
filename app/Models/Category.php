<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // nama tabel di PostgreSQL
    protected $primaryKey = 'id_category'; // primary key custom
    public $timestamps = false; // kalau tidak ada kolom created_at dan updated_at

    protected $fillable = [
        'name_category'
    ];
}
