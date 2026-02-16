<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HousingResource extends JsonResource
{
    private const CITY_LABELS = [
        'sochi' => 'Сочи',
        'gelendzhik' => 'Геленджик',
        'anapa' => 'Анапа',
        'adler' => 'Адлер',
        'krasnodar' => 'Краснодар',
    ];

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'city' => self::CITY_LABELS[$this->city] ?? $this->city,
            'address' => $this->address,
            'price' => (int) $this->price,
            'guests' => (int) $this->guests,
            'bedrooms' => (int) $this->bedrooms,
            'beds' => (int) $this->beds,
            'baths' => (int) $this->baths,
            'image_url' => $this->image_url,
            'description' => $this->description,
            'amenities' => $this->amenities ?? [],
        ];
    }
}
