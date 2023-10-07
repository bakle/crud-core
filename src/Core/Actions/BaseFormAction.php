<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\UseCases;

use Illuminate\Database\Eloquent\Model;

abstract class BaseFormAction
{

    public function __construct(protected readonly array $data, protected Model $model, ...$args)
    {
    }

    abstract public function execute(): Model;
}
