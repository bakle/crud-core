<?php declare(strict_types=1);

namespace Bakle\CrudCore\Core\Searchables;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseSearchable
{
    public function __construct(public ?string $terms)
    {
    }

    abstract protected function apply(Builder $query, string $term): Builder;

    public function search(Builder $query): void
    {
        $this->terms = is_null($this->terms) ? '' : $this->terms;
        collect(explode(' ', $this->terms))->filter()->each(function (string $term) use ($query) {
            $term = '%' . $term . '%';
            $this->apply($query, $term);
        });
    }
}

