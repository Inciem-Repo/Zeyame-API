<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
     protected $table="background";
    // Define the children relationship
    public function children()
    {
        return $this->hasMany(Background::class, 'parent_id');
    }

    // Define a recursive method to retrieve all children categories
    public function getAllChildren()
    {
        return $this->children()->with('getAllChildren');
    }
}
