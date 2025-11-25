<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FontFiles extends Model
{
    protected $table="json_font";
    protected $fillable = [
        'post_name','user_email','post_tags','user_email','image_path'
    ];
}
