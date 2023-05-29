<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'total',
        'payment_method',
        'totalht',
        'order_key',
        'totaltva',
        'currency',
        'status',
    ];
    const PENDING = "PENDING";
    const COMPLETED = "COMPLETED";
    const REFUSED = "REFUSED";
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
