<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // nama tabel di PostgreSQL
    protected $primaryKey = 'id_category'; // primary key custom
    protected $keyType = 'int';
    protected $fillable = [
        'name_category'
    ];
}
