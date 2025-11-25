<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageCategory extends Model
{
    use HasFactory;
    protected $table='image';
    protected $fillable = ['name', 'parent_id', 'sort'];

    public function parent()
    {
        return $this->belongsTo(ImageCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ImageCategory::class, 'parent_id');
    }
}
