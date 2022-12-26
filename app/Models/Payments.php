<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = [
        'orderId',
        'status',
        'gateway',
        'amount',
    ];
    use HasFactory;
}
