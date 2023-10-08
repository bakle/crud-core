<?php declare(strict_types=1);

namespace Tests\Utils\ViewModels;

use Bakle\CrudCore\Core\ViewModels\BaseFormViewModel;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Models\Post;

class UserFormViewModel extends BaseFormViewModel
{

    protected function getEntityClass(): string
    {
        return UserEntity::class;
    }

    protected function getExtraData(): array
    {
        return [
            'post' => new Post()
        ];
    }
}
