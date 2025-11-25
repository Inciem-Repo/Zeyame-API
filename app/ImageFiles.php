<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageFiles extends Model
{
    protected $table="json_image";
    protected $fillable = [
        'post_name','user_email','post_tags','user_email','image_path'
    ];
}
