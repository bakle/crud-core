<?php declare(strict_types=1);

namespace Tests\Utils\ViewModels;

use Bakle\CrudCore\Core\ViewModels\BaseIndexViewModel;
use Tests\Utils\Entities\UserEntity;

class UserIndexViewModel extends BaseIndexViewModel
{
    public function getTitle(): string
    {
        return trans('Users');
    }

    public function getEntityClass(): string
    {
        return UserEntity::class;
    }
}
