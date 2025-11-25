<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosterItems extends Model
{
    use HasFactory;
    protected $table='poster_items';
    protected $fillable = ['p_type','p_style','p_style_value','p_content','p_poster_id','p_type_index'];
    public $timestamps = false;
}
