<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FontCategory extends Model
{
    use HasFactory;
    protected $table='font';
    protected $fillable = ['name', 'parent_id', 'sort'];

    public function parent()
    {
        return $this->belongsTo(FontCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(FontCategory::class, 'parent_id');
    }
}
