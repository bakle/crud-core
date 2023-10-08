<?php declare(strict_types=1);

namespace Tests\Utils\Entities;

use Bakle\CrudCore\Core\Entities\BaseEntity;
use Bakle\CrudCore\Core\Presenters\BaseUrlPresenter;

class CommentEntity extends BaseEntity
{

    public function url(): ?BaseUrlPresenter
    {
        return null;
    }
}
