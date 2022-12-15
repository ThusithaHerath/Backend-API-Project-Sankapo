<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'tittle',
        'images',
        'condition',
        'buy',
        'province',
        'city',
        'town',
        'residential_type',
        'living_area_square_meters',
        'bed_space',
        'running_water',
        'electricity',
        'restroom',
        'room_arrangement',
        'isApprove'
    ];
}