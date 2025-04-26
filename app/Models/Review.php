<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ["review", "rating"];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // public function scope(Builder $query):Builder 
    // {
    //     return $query->   
    // }
}
