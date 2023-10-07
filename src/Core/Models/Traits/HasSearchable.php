<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\Models\Traits;

use Bakle\LskCore\Core\Searchables\BaseSearchable;
use Illuminate\Database\Eloquent\Builder;

trait HasSearchable
{
    public function scopeSearch(Builder $query, BaseSearchable $searchable): void
    {
        $searchable->search($query);
    }
}
