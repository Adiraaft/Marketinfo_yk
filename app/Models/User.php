<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users'; // sesuaikan dengan nama tabel

    protected $primaryKey = 'id_user'; // atau id_user jika tabelmu pakai itu

    protected $fillable = [
        'name',
        'date_of_birth',
        'phone',
        'email',
        'password',
        'market_id',
        'status',
        'role',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function market()
    {
        return $this->belongsTo(Market::class, 'market_id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = false;
}
