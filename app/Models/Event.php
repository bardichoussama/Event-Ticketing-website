<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'category', 'regular_price', 'discount_price'];

    public function recurrences()
    {
        return $this->hasMany(Recurrence::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
