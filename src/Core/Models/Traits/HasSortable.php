<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\Models\Traits;

use Bakle\LskCore\Core\Sortables\BaseSortable;
use Illuminate\Database\Eloquent\Builder;

trait HasSortable
{
    public function scopeSort(Builder $query, BaseSortable $sortable): Builder
    {
        return $sortable->sort($query);
    }
}
