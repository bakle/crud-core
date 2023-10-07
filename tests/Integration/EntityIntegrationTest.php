<?php declare(strict_types=1);

namespace Tests\Integration;


use Tests\BaseTestCase;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Factories\UserFactory;
use Tests\Utils\Models\User;
use Tests\Utils\Presenters\UserUrlPresenter;

class EntityIntegrationTest extends BaseTestCase
{
    public function testItGetsUrlPresenter(): void
    {
        $user = UserFactory::new()->make();

        $userEntity = new UserEntity($user);

        $this->assertInstanceOf(UserUrlPresenter::class, $userEntity->url());
    }
}
