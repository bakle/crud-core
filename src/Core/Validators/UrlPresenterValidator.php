<?php declare(strict_types=1);

namespace Bakle\LskCore\Core\Validators;

use Bakle\LskCore\Core\Entities\BaseEntity;
use Bakle\LskCore\Exceptions\ExtraEntityException;

class UrlPresenterValidator
{

    public static function validateExtraEntities(array $extraEntities): void
    {
        foreach ($extraEntities as $entity) {
            if (!$entity instanceof BaseEntity) {
                throw new ExtraEntityException();
            }
        }
    }
}