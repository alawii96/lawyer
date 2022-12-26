<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'serviceId',
        'quantity',
        'documentId',
        'clientId',
        'name'
    ];
    use HasFactory;
}