<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'salary',
        'savings',
        'year',
        'month',
        'rent_or_emi',
        'food_and_groceries',
        'transportation',
        'utilities',
        'internet_and_mobile',
        'insurance',
        'entertainment',
        'personal_care',
        'miscellaneous'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
