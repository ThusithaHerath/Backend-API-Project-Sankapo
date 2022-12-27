<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class negotiation extends Model
{
    use HasFactory;
    protected $fillable = [
        'negotiation_price',
        'bid_user',
        'auction_id',
    ];
}