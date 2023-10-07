<?php declare(strict_types=1);

namespace Tests\Integration;


use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\BaseTestCase;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Factories\UserFactory;
use Tests\Utils\Models\User;
use Tests\Utils\ViewModels\UserIndexViewModel;

class UserIndexViewModelIntegrationTest extends BaseTestCase
{
    use RefreshDatabase;

    public function testItShouldGetTheCorrectIndexData(): void
    {
        $user = UserFactory::new()->count(3)->create();
        $userQuery = User::query();

        $userIndexViewModel = new UserIndexViewModel($userQuery, new Request());
        $data = $userIndexViewModel->build();

        $this->assertCount(3, $data['entities']);
        $this->assertInstanceOf(Htmlable::class, $data['pagination']);
        $this->assertEquals(trans('Users'), $data['title']);

        $data['entities']->each(function ($item) use ($user) {
            $this->assertInstanceOf(UserEntity::class, $item);
            $this->assertContains($item->getId(), $user->pluck('id'));
        });


    }

}
