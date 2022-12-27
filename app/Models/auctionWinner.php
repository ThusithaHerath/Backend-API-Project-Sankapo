<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auctionWinner extends Model
{
    use HasFactory;
    protected $fillable = [
        'auction_id',
        'user_id',
        'paid',

    ];
}