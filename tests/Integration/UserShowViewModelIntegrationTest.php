<?php declare(strict_types=1);

namespace Tests\Integration;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BaseTestCase;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Factories\UserFactory;
use Tests\Utils\ViewModels\UserShowViewModel;

class UserShowViewModelIntegrationTest extends BaseTestCase
{
    use RefreshDatabase;

    public function testItShouldGetTheCorrectShowData(): void
    {
        $user = UserFactory::new()->create();

        $userShowViewModel = new UserShowViewModel($user);
        $data = $userShowViewModel->build();

        $this->assertInstanceOf(UserEntity::class, $data['entity']);
        $this->assertEquals(trans('User'), $data['title']);

    }

}
