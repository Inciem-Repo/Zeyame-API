<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goldrate extends Model
{
    use HasFactory;
    protected $table = 'goldrate';
    protected $fillable = ['customerid','rate','eightgram','date','silver_rate','nine_rate','nineone_rate','eight_rate','seven_rate','silver_ornament_rate','eightnine'];
    public $timestamps = false;
}
