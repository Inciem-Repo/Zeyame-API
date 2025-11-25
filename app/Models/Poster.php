<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{    public $timestamps = false; 
    use HasFactory;
    protected $table='poster';
       protected $fillable = [
        'category',
        'searchcategory',
        'ofile',  // Add this line
        'dfile',
        'squarelogostyle',
        'todayystyle',
        'onegramstyle',
        'eightgramstyle',
        'addressstyle',
        'webstyle',
        'phonestyle',
        'ecategorymultiple',
        'poster_cpy'
    ];
}
