<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\ViewModels;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use ReflectionClass;

abstract class BaseIndexViewModel
{
    protected LengthAwarePaginator $models;

    abstract public function getTitle(): string;

    abstract public function getEntityClass(): string;

    public function __construct(
        protected readonly Builder $query, protected readonly Request $request
    ) {
        $this->runQuery();
    }

    public function build(): array
    {
        return [
            'items' => $this->getEntities(),
            'pagination' => $this->getPaginationLink(),
            'title' => $this->getTitle()
        ];
    }

    protected function getEntities(): Collection
    {
        $class = new ReflectionClass($this->getEntityClass());
        return $this->models->map(function (Model $model) use ($class) {
            return $class->newInstance($model);
        });
    }

    protected function getPaginationLink(): Htmlable
    {
        return $this->models->links();
    }

    private function runQuery(): void
    {
        $this->models = $this->query->paginate();
    }

}
