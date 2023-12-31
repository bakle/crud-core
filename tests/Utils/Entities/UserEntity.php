<?php declare(strict_types=1);

namespace Tests\Utils\Entities;

use Bakle\CrudCore\Core\Entities\BaseEntity;
use Bakle\CrudCore\Core\Presenters\BaseUrlPresenter;
use Tests\Utils\Presenters\UserUrlPresenter;

class UserEntity extends BaseEntity
{
    public function url(): ?BaseUrlPresenter
    {
        return new UserUrlPresenter($this->model);
    }
}
