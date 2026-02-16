<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Housing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'city',
        'address',
        'price',
        'guests',
        'bedrooms',
        'beds',
        'baths',
        'image_url',
        'description',
        'amenities',
    ];

    protected function casts(): array
    {
        return [
            'amenities' => 'array',
        ];
    }

    public function scopeCity($query, ?string $city): void
    {
        if ($city) {
            $query->where('city', $city);
        }
    }

    public function scopePriceRange($query, ?int $minPrice, ?int $maxPrice): void
    {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
    }

    // guests >= N — жильё вмещает минимум N человек
    public function scopeGuests($query, ?int $guests): void
    {
        if ($guests !== null) {
            $query->where('guests', '>=', $guests);
        }
    }

    public function scopeSortBy($query, ?string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'newest' => $query->orderBy('created_at', 'desc'),
            default => $query->orderBy('id'),
        };
    }
}
