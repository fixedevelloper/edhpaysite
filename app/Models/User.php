<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    const ADMIN_TYPE = 0;
    const AGENT_TYPE = 1;
    const CUSTOMER_TYPE = 2;
    const CAISSE_TYPE = 3;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'lastname',
        'phone',
        'adresse',
        'email',
        'user_type',
        'photo',
        'password',
        'activate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function scopeAdmin($query)
    {
        return $query->where('user_type', '=', 0);
    }

    public function scopeVendeur($query)
    {
        return $query->where('user_type', '=', 1)->where(['activate'=>true]);
    }
    public function scopeCustomer($query)
    {
        return $query->where('user_type', '=', 2)->where(['activate'=>true]);
    }


}
