<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
     protected $table="image";
    // Define the children relationship
    public function children()
    {
        return $this->hasMany(Image::class, 'parent_id');
    }

    // Define a recursive method to retrieve all children categories
    public function getAllChildren()
    {
        return $this->children()->with('getAllChildren');
    }
}
