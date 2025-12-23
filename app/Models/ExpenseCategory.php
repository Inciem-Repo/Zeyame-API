<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['icon_url'];
    protected $hidden = ['icon_file_path'];

    protected function getIconUrlAttribute()
    {

        if (!$this->icon_file_path) {
            return null;
        }

        return Storage::disk('public')->url($this->icon_file_path);
    }
}
