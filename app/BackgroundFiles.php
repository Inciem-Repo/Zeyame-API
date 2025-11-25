<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackgroundFiles extends Model
{
    protected $table="json_background";
    protected $fillable = [
        'post_name','user_email','post_tags','user_email','image_path'
    ];
}
