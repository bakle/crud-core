<?php declare(strict_types=1);

namespace Tests\Integration;


use Tests\BaseTestCase;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Models\User;
use Tests\Utils\Presenters\UserUrlPresenter;

class UrlPresenterIntegrationTest extends BaseTestCase
{
    public function testItReturnsResolvedUrls(): void
    {
        $user = new User();
        $user->id = 1;

        $userEntity = new UserEntity($user);
        $urlPresenter = new UserUrlPresenter($userEntity);

        $this->assertEquals($urlPresenter->index(), route('users.index'));
        $this->assertEquals($urlPresenter->show(), route('users.show', $user->id));
        $this->assertEquals($urlPresenter->edit(), route('users.edit', $user->id));
        $this->assertEquals($urlPresenter->update(), route('users.update', $user->id));
        $this->assertEquals($urlPresenter->create(), route('users.create'));
        $this->assertEquals($urlPresenter->store(), route('users.store'));
        $this->assertEquals($urlPresenter->destroy(), route('users.destroy', $user->id));
    }
}
