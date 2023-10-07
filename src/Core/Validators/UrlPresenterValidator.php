<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\Validators;

use Bakle\LskCore\Core\Entities\BaseEntity;
use Bakle\LskCore\Exceptions\ModelTypeException;
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
