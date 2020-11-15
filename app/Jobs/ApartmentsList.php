<?php

namespace App\Jobs;

use App\Models\Apartment;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApartmentsList
{
    use Dispatchable;

    private array $params;

    public function __construct()
    {
    }

    public function handle(Request $request) : Collection
    {
        $this->params = $request->all()['filter'] ?? [];

        if (count($this->params) === 0) {
            return Apartment::all();
        }

        $result = DB::table('apartments');

        $result = $this->handleBathroomsFilter($result);
        $result = $this->handleBedroomsFilter($result);
        $result = $this->handleStoreysFilter($result);
        $result = $this->handleGaragesFilter($result);
        $result = $this->handlePriceFilter($result);
        $result = $this->handleNameFilter($result);

        return $result->get();
    }

    private function handleBathroomsFilter(Builder $query) : Builder
    {
        return $this->handleNumericFilter($query, 'bathrooms');
    }

    private function handleBedroomsFilter(Builder $query) : Builder
    {
        return $this->handleNumericFilter($query, 'bedrooms');
    }

    private function handleStoreysFilter(Builder $query) : Builder
    {
        return $this->handleNumericFilter($query, 'storeys');
    }

    private function handleGaragesFilter(Builder $query) : Builder
    {
        return $this->handleNumericFilter($query, 'garages');
    }

    private function handlePriceFilter(Builder $query) : Builder
    {
        $value = $this->params['price'] ?? null;
        if ($value && count(explode('-', $value)) === 2) {
            $value = explode('-', $value);
            $query->whereBetween('price', [$value[0], $value[1]]);
        } elseif ($value && !strpos($value,'-')) {
            $query->where('price', '>', $value);
        }

        return $query;
    }

    private function handleNameFilter(Builder $query) : Builder
    {
        $value = $this->params['name'] ?? null;
        if ($value) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        return $query;
    }

    private function handleNumericFilter(Builder $query, string $param) : Builder
    {
        $value = $this->params[$param] ?? null;
        if ($value) {
            $query->where($param, $value);
        }

        return $query;
    }
}
