<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'unit'; // nama tabel
    protected $primaryKey = 'id'; // nama primary key
    protected $fillable = ['name'];

    public $timestamps = false; // ← WAJIB
}
