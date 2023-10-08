<?php declare(strict_types=1);

namespace Tests\Utils\ViewModels;

use Bakle\LskCore\Core\ViewModels\BaseShowViewModel;
use Tests\Utils\Entities\UserEntity;

class UserShowViewModel extends BaseShowViewModel
{
    public function getTitle(): string
    {
        return trans('User');
    }

    public function getEntityClass(): string
    {
        return UserEntity::class;
    }

    protected function getExtraData(): array
    {
        return [
            'title' => $this->getTitle()
        ];
    }
}
