<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundCategory extends Model
{
    use HasFactory;
    protected $table='background';
    protected $fillable = ['name', 'parent_id', 'sort'];

    public function parent()
    {
        return $this->belongsTo(BackgroundCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(BackgroundCategory::class, 'parent_id');
    }
}
