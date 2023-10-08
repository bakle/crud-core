<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\ViewModels;

use Bakle\LskCore\Core\Searchables\BaseSearchable;
use Bakle\LskCore\Core\Sortables\BaseSortable;
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
    protected array $extraModels;

    abstract public function getTitle(): string;

    abstract public function getEntityClass(): string;

    public function __construct(
        protected readonly Builder $query, protected readonly Request $request, private readonly ?int $perPage = null,
        ...$extraModels
    ) {
        $this->extraModels = $extraModels;
        $this->runQuery();
    }

    public function build(): array
    {
        return [
            'entities' => $this->getEntities(),
            'pagination' => $this->getPaginationLink(),
            'title' => $this->getTitle(),
            ...$this->getExtraData(),
        ];
    }

    protected function getEntities(): Collection
    {
        $class = new ReflectionClass($this->getEntityClass());
        return $this->models->map(function (Model $model) use ($class) {
            return $class->newInstance($model, ...$this->extraModels);
        });
    }

    protected function getPaginationLink(): Htmlable
    {
        return $this->models->links();
    }

    private function runQuery(): void
    {
        $this->models = $this->query
            ->when(
                $this->isSortable(),
                fn(Builder $query) => $query->sort($this->getSortable())
            )
            ->when(
                $this->isSearchable(),
                fn(Builder $query) => $query->search($this->getSearchable())
            )
            ->paginate($this->perPage);
    }

    protected function getExtraData(): array
    {
        return [];
    }

    protected function getSortable(): ?BaseSortable
    {
        return null;
    }

    protected function getSearchable(): ?BaseSearchable
    {
        return null;
    }

    protected function hasExtraModels(): bool
    {
        return count($this->extraModels) > 0;
    }

    private function isSortable(): bool
    {
        return $this->getSortable() !== null;
    }

    private function isSearchable(): bool
    {
        return $this->getSearchable() !== null;
    }

}
