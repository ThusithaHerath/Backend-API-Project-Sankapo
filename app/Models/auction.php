<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auction extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoryId',
        'userId',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'starting_price',
        'end_price',
        'status'
    ];
}