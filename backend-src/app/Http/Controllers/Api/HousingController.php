<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexHousingRequest;
use App\Http\Resources\HousingResource;
use App\Models\Housing;

class HousingController extends Controller
{
    public function index(IndexHousingRequest $request)
    {
        $validated = $request->validated();

        $housings = Housing::query()
            ->city($validated['city'] ?? null)
            ->priceRange(
                $validated['min_price'] ?? null,
                $validated['max_price'] ?? null
            )
            ->guests($validated['guests'] ?? null)
            ->sortBy($validated['sort'] ?? null)
            ->paginate($validated['per_page'] ?? 9); // 9 = 3 колонки на десктопе

        return HousingResource::collection($housings);
    }

    public function show(int $id)
    {
        $housing = Housing::findOrFail($id);

        return new HousingResource($housing);
    }
}
