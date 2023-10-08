<?php declare(strict_types=1);

namespace Bakle\CrudCore\Core\ViewModels;


use Bakle\CrudCore\Core\Entities\BaseEntity;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

abstract class BaseShowViewModel
{
    protected array $extraModels = [];

    public function __construct(protected Model $model, ...$extraModels)
    {
        $this->extraModels = $extraModels;
    }

    abstract protected function getEntityClass(): string;

    public function build(): array
    {
        return [
            'entity' => $this->getEntity(),
            ...$this->getExtraData(),
        ];
    }

    protected function getEntity(): BaseEntity
    {
        $class = new ReflectionClass($this->getEntityClass());

        return $class->newInstance($this->model, ...$this->extraModels);
    }

    protected function getExtraData(): array
    {
        return [];
    }

}
