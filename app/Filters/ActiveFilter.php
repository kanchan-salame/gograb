<?php
namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ActiveFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value == 'user') {
            $query->where('role', 'user');
        }

        if ($value == 'driver') {
            $query->where('role', 'driver');
        }
    }
}
