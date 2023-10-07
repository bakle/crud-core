<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\Presenters;

use Bakle\LskCore\Core\Enums\RouteMethods;
use Bakle\LskCore\Core\Validators\UrlPresenterValidator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class BaseUrlPresenter
{
    private array $modelsRouteKey = [];
    protected array $models = [];
    private array $modelsRouteKeyExceptLast = [];

    public function __construct(
        ...$models
    ) {
        if ($models) {
            UrlPresenterValidator::validateModels($models);
            $this->setExtraEntitiesIds($models);
        }

        $this->models = $models;

    }

    abstract protected function getRouteName(): string;

    public function index(): string
    {
        if (count($this->modelsRouteKey) > 1) {
            return route($this->getRouteName() . '.' . RouteMethods::INDEX->value, $this->modelsRouteKeyExceptLast);
        }

        return route($this->getRouteName() . '.' . RouteMethods::INDEX->value);
    }

    public function show(): string
    {
        return route($this->getRouteName() . '.' . RouteMethods::SHOW->value, $this->modelsRouteKey);
    }

    public function edit(): string
    {
        return route(
            $this->getRouteName() . '.' . RouteMethods::EDIT->value, $this->modelsRouteKey
        );
    }

    public function update(): string
    {
        return route(
            $this->getRouteName() . '.' . RouteMethods::UPDATE->value, $this->modelsRouteKey
        );
    }

    public function create(): string
    {
        if (count($this->modelsRouteKey) > 1) {
            return route($this->getRouteName() . '.' . RouteMethods::CREATE->value, $this->modelsRouteKeyExceptLast);
        }

        return route($this->getRouteName() . '.' . RouteMethods::CREATE->value);
    }

    public function store(): string
    {
        if (count($this->modelsRouteKey) > 1) {
            return route($this->getRouteName() . '.' . RouteMethods::STORE->value, $this->modelsRouteKeyExceptLast);
        }

        return route($this->getRouteName() . '.' . RouteMethods::STORE->value);
    }

    public function destroy(): string
    {
        return route(
            $this->getRouteName() . '.' . RouteMethods::DESTROY->value, $this->modelsRouteKey
        );
    }

    protected function hasEntities(): bool
    {
        return count($this->models) > 0;
    }

    private function setExtraEntitiesIds(array $models): void
    {
        $this->modelsRouteKey = Arr::map($models, fn(Model $models) => $models->getRouteKey());
        $this->modelsRouteKeyExceptLast = array_slice($this->modelsRouteKey, 0, -1);
    }
}
