<?php declare(strict_types=1);

namespace Bakle\CrudCore\Core\Entities;

use Bakle\CrudCore\Core\Presenters\BaseUrlPresenter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEntity
{
    protected array $extraModels;

    public function __construct(protected readonly Model $model, ...$extraModels)
    {
        $this->extraModels = $extraModels;
    }

    abstract public function url(): ?BaseUrlPresenter;

    public function getModelName(): string
    {
        return class_basename($this->model);
    }

    public static function collection(Collection $models): \Illuminate\Support\Collection
    {
        return $models->map(function (Model $model) {
            return new static($model);
        });
    }

    public function getId(): ?int
    {
        return $this->model->getKey();
    }

    public function getCreatedAtDayDateFormat(): string
    {
        return $this->model->created_at->toFormattedDayDateString();
    }

    protected function hasExtraModels(): bool
    {
        return count($this->extraModels) > 0;
    }

}
