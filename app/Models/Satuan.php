<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $table = 'unit'; // nama tabel
    protected $fillable = ['name'];

    public $timestamps = false; // ← WAJIB
}
