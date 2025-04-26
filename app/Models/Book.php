<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ["title","author"];

    public function reviews() 
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where("title", "Like", "%{$title}%");
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount([
            "reviews" => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])->orderBy("reviews_count","desc"); 
    }

    public function scopeHighRated(Builder $query): Builder
    {
        return $query->withAvg("reviews", "rating")->orderBy("reviews_avg_rating", "desc");
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
            if ($from && !$to)
            {
                $query->where("created_at", "<=", $from);               
            } elseif (!$from && $to)
            {
                $query->where("created_at", "<=", $to);
            } elseif ($from && $to)
            {
                $query->whereBetween("created_at", [$from, $to]);
            }
    }
}
