<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'user_id',
        'recipient_name',
        'email',
        'message',
        'subtotal',
        'shipping_cost',
        'total',
        'payment_status',
    ];
}
