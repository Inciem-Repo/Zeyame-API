<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Font extends Model
{
     protected $table="font";
    // Define the children relationship
    public function children()
    {
        return $this->hasMany(Font::class, 'parent_id');
    }

    // Define a recursive method to retrieve all children categories
    public function getAllChildren()
    {
        return $this->children()->with('getAllChildren');
    }
}
