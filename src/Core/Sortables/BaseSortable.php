<?php declare(strict_types=1);

namespace Bakle\CrudCore\Core\Sortables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class BaseSortable
{
    protected string $column = '';
    protected string $order = 'asc';

    public function __construct(public Request $request)
    {
        $this->resolveParams();
    }

    abstract protected function apply(Builder $builder): Builder;

    public function sort(Builder $builder): Builder
    {
        return $this->apply($builder);
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    protected function simpleSort(Builder $query): Builder
    {
        return $query->orderBy($this->column, $this->order);
    }

    private function resolveParams(): void
    {
        if (!$this->request->has('sort')) {
            return;
        }

        [$this->column, $this->order] = explode(',', $this->request->input('sort'));
        $this->order = $this->order ?? 'asc';
    }
}

