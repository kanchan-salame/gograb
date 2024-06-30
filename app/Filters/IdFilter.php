<?php
namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class IdFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('id', $value);
    }
}
