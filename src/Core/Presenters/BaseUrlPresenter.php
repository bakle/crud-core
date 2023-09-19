<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\Presenters;

use Bakle\LskCore\Core\Entities\BaseEntity;
use Bakle\LskCore\Core\Enums\RouteMethods;
use Bakle\LskCore\Core\Validators\UrlPresenterValidator;
use Illuminate\Support\Arr;

abstract class BaseUrlPresenter
{
    private array $entitiesIds = [];
    protected array $entities = [];
    private array $entitiesIdsExceptLast = [];

    public function __construct(
        ...$entities
    ) {
        if ($entities) {
            UrlPresenterValidator::validateEntities($entities);
            $this->setExtraEntitiesIds($entities);
        }

        $this->entities = $entities;

    }

    abstract protected function getRouteName(): string;

    public function index(): string
    {
        if (count($this->entitiesIds) > 1) {
            return route($this->getRouteName() . '.' . RouteMethods::INDEX->value, $this->entitiesIdsExceptLast);
        }

        return route($this->getRouteName() . '.' . RouteMethods::INDEX->value);
    }

    public function show(): string
    {
        return route($this->getRouteName() . '.' . RouteMethods::SHOW->value, $this->entitiesIds);
    }

    public function edit(): string
    {
        return route(
            $this->getRouteName() . '.' . RouteMethods::EDIT->value, $this->entitiesIds
        );
    }

    public function update(): string
    {
        return route(
            $this->getRouteName() . '.' . RouteMethods::UPDATE->value, $this->entitiesIds
        );
    }

    public function create(): string
    {
        if (count($this->entitiesIds) > 1) {
            return route($this->getRouteName() . '.' . RouteMethods::CREATE->value, $this->entitiesIdsExceptLast);
        }

        return route($this->getRouteName() . '.' . RouteMethods::CREATE->value);
    }

    public function store(): string
    {
        if (count($this->entitiesIds) > 1) {
            return route($this->getRouteName() . '.' . RouteMethods::STORE->value, $this->entitiesIdsExceptLast);
        }

        return route($this->getRouteName() . '.' . RouteMethods::STORE->value);
    }

    public function destroy(): string
    {
        return route(
            $this->getRouteName() . '.' . RouteMethods::DESTROY->value, $this->entitiesIds
        );
    }

    protected function hasEntities(): bool
    {
        return count($this->entities) > 0;
    }

    private function setExtraEntitiesIds(array $entities): void
    {
        $this->entitiesIds = Arr::map($entities, fn(BaseEntity $entity) => $entity->getId());
        $this->entitiesIdsExceptLast = array_slice($this->entitiesIds, 0, -1);
    }
}
