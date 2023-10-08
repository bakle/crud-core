<?php declare(strict_types=1);

namespace Bakle\CrudCore\Core\Validators;

use Bakle\CrudCore\Core\Entities\BaseEntity;
use Bakle\CrudCore\Exceptions\ModelTypeException;
use Illuminate\Database\Eloquent\Model;

class UrlPresenterValidator
{

    public static function validateModels(array $models): void
    {
        foreach ($models as $model) {
            if (!$model instanceof Model) {
                throw new ModelTypeException();
            }
        }
    }
}
