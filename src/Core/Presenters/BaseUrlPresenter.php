<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\Presenters;

use Bakle\LskCore\Core\Entities\BaseEntity;
use Bakle\LskCore\Core\Enums\RouteMethods;
use Bakle\LskCore\Core\Validators\UrlPresenterValidator;
use Illuminate\Support\Arr;

abstract class BaseUrlPresenter
{

    protected string $routeName;
    private array $entitiesIds = [];
    private array $entitiesIdsExceptLast = [];

    public function __construct(
        ...$entities
    ) {
        if ($entities) {
            UrlPresenterValidator::validateEntities($entities);
            $this->setExtraEntitiesIds($entities);
        }

        $this->setRouteName();
    }

    abstract function setRouteName(): void;

    public function index(): string
    {
        if (count($this->entitiesIds) > 1) {
            return route($this->routeName . '.' . RouteMethods::INDEX->value, $this->entitiesIdsExceptLast);
        }

        return route($this->routeName . '.' . RouteMethods::INDEX->value);
    }

    public function show(): string
    {
        return route($this->routeName . '.' . RouteMethods::SHOW->value, $this->entitiesIds);
    }

    public function edit(): string
    {
        return route($this->routeName . '.' . RouteMethods::EDIT->value, $this->entitiesIds
        );
    }

    public function update(): string
    {
        return route($this->routeName . '.' . RouteMethods::UPDATE->value, $this->entitiesIds
        );
    }

    public function create(): string
    {
        if (count($this->entitiesIds) > 1) {
            return route($this->routeName . '.' . RouteMethods::CREATE->value, $this->entitiesIdsExceptLast);
        }

        return route($this->routeName . '.' . RouteMethods::CREATE->value);
    }

    public function store(): string
    {
        if (count($this->entitiesIds) > 1) {
            return route($this->routeName . '.' . RouteMethods::STORE->value, $this->entitiesIdsExceptLast);
        }

        return route($this->routeName . '.' . RouteMethods::STORE->value);
    }

    public function destroy(): string
    {
        return route($this->routeName . '.' . RouteMethods::DESTROY->value, $this->entitiesIds
        );
    }

    private function setExtraEntitiesIds(array $entities): void
    {
        $this->entitiesIds = Arr::map($entities, fn(BaseEntity $entity) => $entity->getId());
        $this->entitiesIdsExceptLast = array_slice($this->entitiesIds, 0, -1);
    }
}
