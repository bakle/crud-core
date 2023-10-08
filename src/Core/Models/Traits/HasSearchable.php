<?php declare(strict_types=1);

namespace Bakle\CrudCore\Core\Models\Traits;

use Bakle\CrudCore\Core\Searchables\BaseSearchable;
use Illuminate\Database\Eloquent\Builder;

trait HasSearchable
{
    public function scopeSearch(Builder $query, BaseSearchable $searchable): void
    {
        $searchable->search($query);
    }
}
