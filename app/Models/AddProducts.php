<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddProducts extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'category',
        'images',
        'condition'
    ];
}
