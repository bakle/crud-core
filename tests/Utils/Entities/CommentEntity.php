<?php declare(strict_types=1);

namespace Tests\Utils\Entities;

use Bakle\LskCore\Core\Entities\BaseEntity;
use Bakle\LskCore\Core\Presenters\BaseUrlPresenter;

class CommentEntity extends BaseEntity
{

    public function url(): ?BaseUrlPresenter
    {
        return null;
    }
}
