<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contracts extends Model
{
    protected $fillable = [
        'category',
        'price',
        'name'
    ];
    use HasFactory;
}
